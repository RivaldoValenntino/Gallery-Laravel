/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: "class",
    theme: {
        extend: {},
        fontFamily: {
            "great-vibes": ["Great Vibes", "cursive"],
            nunito: ["Nunito", "sans-serif"],
            "dancing-script": ["Dancing Script", "cursive"],
            "noto-sans": ["Noto Sans", "sans-serif"],
        },
    },
    plugins: [require("flowbite/plugin")],
};
