import { createConfigForNuxt } from '@nuxt/eslint-config/flat'

export default createConfigForNuxt({
    features: {
        stylistic: {
            braceStyle: '1tbs',
            indent: 4,
            commaDangle: 'never'
        }
    }
})
    .append({
        rules: {
            '@stylistic/space-before-function-paren': ['error', 'always']
        }
    })
    .append({
        ignores: [
            'bootstrap/ssr/**',
            'public/**',
            'storage/**',
            'vendor/**',
            // Written by `php artisan ziggy:generate`.
            'resources/js/ziggy.js'
        ]
    })
    .append({
        rules: {
            // Inertia routes pages by file name and the Jetstream components
            // this app is built on are single words, so the whole tree is.
            'vue/multi-word-component-names': 'off',
            // `Head` is Inertia's own component.
            'vue/no-reserved-component-names': 'off'
        }
    })
