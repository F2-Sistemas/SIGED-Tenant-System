import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', /*
    darkMode: 'media', // 'media' | 'class' /* */
    content: [
        './node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        './node_modules/flowbite/**/*.{js,jsx,ts,tsx}',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
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
    },

    plugins: [
        flowbite,
        forms,
    ],
};

// --------------------
// // wrorks from here

// const DefaultTheme = require('tailwindcss/defaultTheme');

// /** @type {import('tailwindcss').Config} */
// module.exports = {
//     content: [
//         './node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
//         './node_modules/flowbite/**/*.{js,jsx,ts,tsx}',
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/views/**/*.blade.php',
//         './resources/js/**/*.vue',
//     ],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...DefaultTheme.fontFamily.sans],
//             },
//         },
//     },

//     plugins: [
//         require('flowbite/plugin'),
//         require('@tailwindcss/forms'),
//     ],
// }
