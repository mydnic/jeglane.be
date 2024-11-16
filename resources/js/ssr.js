// import './bootstrap'
import '../css/app.css'
import 'primeicons/primeicons.css'

import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import Aura from '@primevue/themes/aura'
import PrimeVue from 'primevue/config'
import ToastService from 'primevue/toastservice'
import dayjs from 'dayjs'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

const appName = import.meta.env.VITE_APP_NAME || 'Jeglane.be'

createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
        title: title => `${title} - ${appName}`,
        resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
        setup ({ App, props, plugin }) {
            const app = createSSRApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue)
                .use(PrimeVue, {
                    theme: {
                        preset: Aura,
                        options: {
                            darkModeSelector: 'disabled'
                        }
                    }
                })
                .use(ToastService)
                .component('Link', Link)
                .component('Head', Head)

            app.config.globalProperties.$dayjs = dayjs

            return app
        }
    })
)
