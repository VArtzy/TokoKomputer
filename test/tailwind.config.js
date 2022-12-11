/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./**/*.{html,php,js}"],
    theme: {
        extend: {
            fontFamily: {
                'dm': ['DM Sans', 'system-ui', 'arial'],
                'rb': ['Roboto', 'arial']
            }
        },
    },
    plugins: [require("daisyui")],
}
