import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link, router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import ui from '@nuxt/ui/vue-plugin'
import UApp from '@nuxt/ui/components/App.vue'
import dayjs from 'dayjs'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

const appName = import.meta.env.VITE_APP_NAME || 'Jeglane.be'

// Inertia writes history.replaceState on every window scroll to persist the
// scroll position, and it replaces the state again on any same-URL visit.
// Rybbit's SPA auto-tracking patches pushState/replaceState and logs a
// pageview on each call, so reading one page was counted as browsing it ten
// times or more. SPA auto-tracking is now off in the Rybbit site config and
// the pageview is emitted here instead, once per real pathname change. The
// initial load is still tracked by the script itself.
//
// Half of that lives outside this repository: the script hardcodes
// autoTrackSpa to true and only learns otherwise from
// /site/tracking-config/<site-id>. If that call ever fails the script patches
// history again and every navigation is counted twice, which is roughly the
// old inflation. tests/Browser/pageview-tracking.mjs measures all three cases.
let lastTrackedPath = window.location.pathname

router.on('navigate', () => {
    if (window.location.pathname === lastTrackedPath) {
        return
    }

    lastTrackedPath = window.location.pathname
    window.rybbit?.pageview()
})

createInertiaApp({
    title: title => `${title} - ${appName}`,
    resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup ({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(UApp, () => h(App, props)) })
            .use(plugin)
            .use(ZiggyVue)
            .use(ui)
            .component('Link', Link)
            .component('Head', Head)

        app.config.globalProperties.$dayjs = dayjs

        return app.mount(el)
    },
    progress: {
        color: '#4B5563'
    }
})
