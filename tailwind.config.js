/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./**/*.{html,php,js}"],
    theme: {
        extend: {},
    },
    plugins: [require("daisyui")],
}
