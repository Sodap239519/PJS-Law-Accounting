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
                    DEFAULT: '#2563eb', // royal blue (primary)
                    dark: '#1d4ed8',
                    light: '#60a5fa',
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                },
                'pjs-navy': {
                    DEFAULT: '#172554', // sidebar / dark surfaces
                    light: '#1e3a8a',
                },
                'pjs-bg': '#f0f5ff', // soft page background
                'pjs-gold': {
                    DEFAULT: '#c5a647',
                    dark: '#a88b3a',
                    light: '#d4b968',
                },
            },
            boxShadow: {
                soft: '0 10px 30px -12px rgba(37, 99, 235, 0.18)',
            },
        },
    },

    plugins: [forms, typography],
};
