/**
 * Counts the pageviews a browsing session actually sends to Rybbit.
 *
 * Run it with: yarn test:tracking
 * It needs a Chromium: npx playwright-core install chromium
 *
 * The page it drives is not the real app, it is the smallest thing that
 * reproduces the bug: the real Rybbit script, the real Inertia router, and the
 * tracking code read straight out of resources/js/app.js. Nothing reaches
 * production, every request to the Rybbit host is answered locally.
 */

import http from 'node:http'
import fs from 'node:fs'
import path from 'node:path'
import { build } from 'esbuild'
import { chromium } from 'playwright-core'

const root = path.resolve(path.dirname(new URL(import.meta.url).pathname), '../..')
const out = path.join(root, 'node_modules/.cache/pageview-tracking')

const RYBBIT_HOST = 'https://rybbit.dricle.be/api'
const SITE_ID = '4656fbe913f7'

// What the Rybbit dashboard serves for this site today.
const SITE_CONFIG = {
    type: 'web',
    trackOutbound: true,
    trackUrlParams: true,
    trackInitialPageView: true,
    trackSpaNavigation: false,
    trackErrors: false,
    trackButtonClicks: false,
    trackCopy: false,
    trackFormInteractions: false,
    featureFlagsEnabled: false,
    sessionReplay: false,
    webVitals: false
}

const sleep = ms => new Promise(resolve => setTimeout(resolve, ms))

function trackingSnippet () {
    const app = fs.readFileSync(path.join(root, 'resources/js/app.js'), 'utf8')
    const from = app.indexOf('let lastTrackedPath')
    const to = app.indexOf('createInertiaApp(')

    if (from === -1 || to === -1 || to < from) {
        throw new Error('could not find the tracking code in resources/js/app.js')
    }

    return app.slice(from, to).trim()
}

async function bundle (name, snippet) {
    const entry = path.join(out, `entry.${name}.js`)
    const file = path.join(out, `bundle.${name}.js`)

    fs.mkdirSync(out, { recursive: true })
    fs.writeFileSync(entry, `
import { createApp, h } from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'

${snippet}

createInertiaApp({
    resolve: name => ({ name, render: () => h('div', { style: 'height: 8000px' }, name) }),
    setup ({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) }).use(plugin).mount(el)
    }
})

window.__router = router
`)

    await build({
        entryPoints: [entry],
        bundle: true,
        format: 'esm',
        define: { 'process.env.NODE_ENV': '"production"' },
        absWorkingDir: root,
        outfile: file,
        logLevel: 'warning'
    })

    return fs.readFileSync(file, 'utf8')
}

function serve (script) {
    const page = url => ({
        component: { '/': 'Home', '/locations': 'Locations' }[new URL(url, 'http://x').pathname] ?? 'Home',
        props: {},
        url,
        version: '1',
        clearHistory: false,
        encryptHistory: false
    })

    const server = http.createServer((req, res) => {
        if (req.headers['x-inertia']) {
            res.writeHead(200, { 'Content-Type': 'application/json', 'X-Inertia': 'true', 'Vary': 'X-Inertia' })
            res.end(JSON.stringify(page(req.url)))
            return
        }

        res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' })
        res.end(`<!DOCTYPE html>
<html lang="fr">
<head><meta charset="utf-8"><title>tracking</title>
<script src="${RYBBIT_HOST}/script.js" data-site-id="${SITE_ID}" defer></script>
</head>
<body>
<div id="app" data-page='${JSON.stringify(page(req.url)).replace(/'/g, '&#039;')}'></div>
<script type="module">${script}</script>
</body>
</html>`)
    })

    return new Promise((resolve) => {
        server.listen(0, '127.0.0.1', () => resolve({ server, port: server.address().port }))
    })
}

// A reader scrolls, pauses, scrolls again. Inertia writes history.replaceState
// on each pause to remember the scroll position, and the Rybbit script
// debounces its own pageview by 500ms, so every pause longer than that used to
// count as another view of the same page.
async function read (page, bursts) {
    for (let i = 0; i < bursts; i++) {
        for (let j = 0; j < 4; j++) {
            await page.mouse.wheel(0, 200)
            await sleep(20)
        }
        await sleep(700)
    }
}

async function session ({ name, script, config, rybbitScript }) {
    const { server, port } = await serve(script)
    const browser = await chromium.launch()
    const page = await browser.newPage({ viewport: { width: 1280, height: 720 } })
    const sent = []

    await page.route(`${RYBBIT_HOST}/script.js`, route =>
        route.fulfill({ status: 200, contentType: 'application/javascript', body: rybbitScript }))

    await page.route(`${RYBBIT_HOST}/site/tracking-config/**`, route =>
        config === null
            ? route.abort('failed')
            : route.fulfill({ status: 200, contentType: 'application/json', body: JSON.stringify(config) }))

    await page.route(`${RYBBIT_HOST}/track`, (route) => {
        const body = JSON.parse(route.request().postData() ?? '{}')
        sent.push(`${body.pathname}${body.querystring ?? ''}`)
        return route.fulfill({ status: 200, contentType: 'application/json', body: '{}' })
    })

    const steps = []
    const step = async (label) => {
        const before = steps.reduce((total, s) => total + s.count, 0)
        await sleep(600)
        steps.push({ label, count: sent.length - before, urls: sent.slice(before) })
    }

    await page.goto(`http://127.0.0.1:${port}/`)
    await page.waitForFunction(() => window.rybbit && window.__router, null, { timeout: 15000 })
    await step('land on /')

    await read(page, 10)
    await step('read / (10 scroll pauses)')

    await page.evaluate(() => window.__router.visit('/locations'))
    await page.waitForFunction(() => location.pathname === '/locations')
    await step('go to /locations')

    await read(page, 10)
    await step('read /locations (10 scroll pauses)')

    await page.evaluate(() => window.__router.visit('/locations'))
    await step('visit /locations again, same url')

    await page.evaluate(() => window.__router.visit('/locations?zoom=12&lat=50.8'))
    await page.waitForFunction(() => location.search.includes('zoom'))
    await step('pan the map, query string only')

    await page.goBack()
    await page.waitForFunction(() => location.search === '')
    await step('back, query string only')

    for (let i = 0; i < 5 && await page.evaluate(() => location.pathname) !== '/'; i++) {
        await page.goBack()
        await sleep(200)
    }
    await step('back to /')

    await browser.close()
    server.close()

    console.log(`\n${name}`)
    for (const s of steps) {
        console.log(`  ${String(s.count).padStart(3)} pageview(s)  ${s.label}${s.urls.length ? `  -> ${s.urls.join(', ')}` : ''}`)
    }
    console.log(`  ${sent.length} pageviews for 3 real page changes`)

    return steps.map(s => s.count)
}

const rybbitScript = await fetch(`${RYBBIT_HOST}/script.js`).then(r => r.text())
const fixed = await bundle('fixed', trackingSnippet())
const bare = await bundle('bare', '')

const counts = await session({
    name: 'This branch, with the Rybbit config this site serves today:',
    script: fixed,
    config: SITE_CONFIG,
    rybbitScript
})

await session({
    name: 'Without the tracking code, with SPA auto-tracking on (the bug):',
    script: bare,
    config: { ...SITE_CONFIG, trackSpaNavigation: true },
    rybbitScript
})

await session({
    name: 'This branch, tracking-config unreachable (script falls back to SPA auto-tracking):',
    script: fixed,
    config: null,
    rybbitScript
})

const expected = [1, 0, 1, 0, 0, 0, 0, 1]
const ok = counts.length === expected.length && counts.every((n, i) => n === expected[i])

console.log(`\n${ok ? 'PASS' : 'FAIL'}: expected ${expected.join(',')} got ${counts.join(',')}`)

if (!ok) {
    process.exit(1)
}
