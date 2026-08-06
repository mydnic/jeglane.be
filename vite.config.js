import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import ui from '@nuxt/ui/vite'

export default defineConfig({
    ssr: {
        noExternal: ['@inertiajs/server']
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        }),
        // Nuxt UI bundles unplugin-vue-components, so the app's own component
        // dirs and resolvers are configured through it rather than separately.
        ui({
            router: 'inertia',
            dts: false,
            colorMode: false,
            ui: {
                colors: {
                    primary: 'emerald'
                }
            },
            components: {
                dirs: ['resources/js/Components'],

                resolvers: [
                    (componentName) => {
                        // where `componentName` is always CapitalCase
                        if (componentName.endsWith('IconSolid')) {
                            return { name: componentName.slice(0, -5), from: '@heroicons/vue/24/solid' }
                        }
                        if (componentName.endsWith('IconOutline')) {
                            return { name: componentName.slice(0, -7), from: '@heroicons/vue/24/outline' }
                        }
                        if (componentName.endsWith('IconMini')) {
                            return { name: componentName.slice(0, -4), from: '@heroicons/vue/20/solid' }
                        }
                    }
                ]
            }
        })
    ]
})
