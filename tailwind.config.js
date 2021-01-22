const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        content: [
            './vendor/laravel/jetstream/**/*.blade.php',
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php',
        ],
        options: {
            safelist: ['text-local', 'bg-local', 'text-b2', 'bg-b2', 'text-s3', 'bg-s3'],
        }
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
