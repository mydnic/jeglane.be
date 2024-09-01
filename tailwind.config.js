import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            'primary': {
                '50': '#f1fcf1',
                '100': '#dff9e1',
                '200': '#c0f2c3',
                '300': '#8fe695',
                '400': '#56d25f',
                '500': '#2ba635',
                '600': '#22972b',
                '700': '#1e7725',
                '800': '#1d5e23',
                '900': '#194e1f',
                '950': '#082b0d',
            },

        }
    },

    plugins: [forms, typography],
};
