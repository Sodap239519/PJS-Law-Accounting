import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Prompt', 'Figtree', ...defaultTheme.fontFamily.sans],
                prompt: ['Prompt', 'sans-serif'],
            },
            colors: {
                'pjs-blue': {
                    DEFAULT: '#1e3a8a',
                    dark: '#1e40af',
                    light: '#3b82f6',
                },
                'pjs-gold': {
                    DEFAULT: '#c5a647',
                    dark: '#a88b3a',
                    light: '#d4b968',
                },
            },
        },
    },

    plugins: [forms, typography],
};
