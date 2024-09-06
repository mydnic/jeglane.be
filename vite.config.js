import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

import Components from 'unplugin-vue-components/vite'
import { PrimeVueResolver } from '@primevue/auto-import-resolver'

export default defineConfig({
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
        Components({
            dirs: ['resources/js/Components'],

            resolvers: [
                PrimeVueResolver(),
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
        })
    ]
})
