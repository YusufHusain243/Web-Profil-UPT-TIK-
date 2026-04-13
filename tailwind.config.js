import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#003366',
                    light: '#004080',
                    dark: '#00264d',
                },
                secondary: {
                    DEFAULT: '#FFCC00',
                    light: '#FFD633',
                    dark: '#E6B800',
                },
                accent: {
                    DEFAULT: '#00A859',
                    light: '#00C266',
                    dark: '#008F4C',
                },
                surface: {
                    DEFAULT: '#F8FAFC',
                    dark: '#0F172A',
                }
            },
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in-down': {
                    '0%': { opacity: '0', transform: 'translateY(-20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                }
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.6s ease-out forwards',
                'fade-in-down': 'fade-in-down 0.6s ease-out forwards',
            }
        },
    },

    plugins: [forms],
};
