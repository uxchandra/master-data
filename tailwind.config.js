import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#364e4c',
                sage: {
                    50: '#f6f7f6',
                    100: '#e3e7e3',
                    200: '#c7cfc8',
                    300: '#a3b0a5',
                    400: '#7d8e7f',
                    500: '#5f7161',
                    600: '#4a5a4c',
                    700: '#3d4a3f',
                    800: '#343d35',
                    900: '#2c342d',
                    950: '#171c18',
                },
            },
        },
    },

    plugins: [forms],
};
