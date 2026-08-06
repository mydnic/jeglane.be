import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import ui from '@nuxt/ui/vue-plugin'
import UApp from '@nuxt/ui/components/App.vue'
import dayjs from 'dayjs'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

const appName = import.meta.env.VITE_APP_NAME || 'Jeglane.be'

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
