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
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#c74c09',
                    50: '#fdf3f0',
                    100: '#fce6de',
                    200: '#fad0c2',
                    300: '#f6b09c',
                    400: '#f08269',
                    500: '#c74c09',
                    600: '#a63a08',
                    700: '#8a310d',
                    800: '#732d10',
                    900: '#461908',
                },
                surface: {
                    DEFAULT: '#ffffff',
                    dark: '#18181b',
                },
            },
        },
    },

    plugins: [forms, typography],
};
