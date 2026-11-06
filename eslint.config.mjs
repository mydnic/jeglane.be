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
        // Inertia pages are routed by file name, so they are single words by
        // design, and `Head` is Inertia's own component.
        files: ['resources/js/Pages/**'],
        rules: {
            'vue/multi-word-component-names': 'off',
            'vue/no-reserved-component-names': 'off'
        }
    })
