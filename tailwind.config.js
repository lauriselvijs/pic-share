/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        colors: {
            sunset: "#ffe2d6",
            shadow: "#43374f",
            black: colors.black,
            white: colors.white,
        },
        extend: {},
        fontFamily: {
            sans: ["Quicksand", "sans-serif"],
        },
    },
    plugins: [],
};
