/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        screens: {
            sm: "770px",
            md: "1200px",
        },
        colors: {
            sunset: "#ffe2d6",
            shadow: "#43374f",
            error: "#d30124",
            black: colors.black,
            white: colors.white,
        },
        extend: {},
        fontFamily: {
            sans: ["Quicksand", "Arial", "sans-serif"],
        },
    },
    plugins: [],
};
