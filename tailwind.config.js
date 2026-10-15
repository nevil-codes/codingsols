import defaultTheme from 'tailwindcss/defaultTheme';
import colors from 'tailwindcss/colors';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        // Only scan files in the repo: vendor/ and storage/ differ between build
        // steps, which would give the CSS a different hash in each build.
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                gray: colors.zinc,
                accent: colors.indigo,
            },
            fontFamily: {
                sans: ['"Inter Variable"', ...defaultTheme.fontFamily.sans],
                mono: ['"JetBrains Mono Variable"', ...defaultTheme.fontFamily.mono],
            },
            typography: ({ theme }) => ({
                DEFAULT: {
                    css: {
                        'code::before': { content: 'none' },
                        'code::after': { content: 'none' },
                        code: {
                            fontWeight: '500',
                            backgroundColor: theme('colors.zinc.100'),
                            padding: '0.15rem 0.35rem',
                            borderRadius: '0.25rem',
                        },
                        'pre code': { backgroundColor: 'transparent', padding: '0' },
                        pre: {
                            backgroundColor: theme('colors.zinc.50'),
                            color: theme('colors.zinc.800'),
                            border: `1px solid ${theme('colors.zinc.200')}`,
                        },
                    },
                },
                invert: {
                    css: {
                        code: { backgroundColor: theme('colors.zinc.800') },
                        'pre code': { backgroundColor: 'transparent' },
                        pre: {
                            backgroundColor: theme('colors.zinc.900'),
                            color: theme('colors.zinc.100'),
                            borderColor: theme('colors.zinc.800'),
                        },
                    },
                },
            }),
        },
    },

    plugins: [forms, typography],
};
