import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/css/**/*.js",
    ],
    darkMode: ["class", '[data-mode="dark"]'],
    theme: {
        container: {
            center: true,
            padding: "1.5rem",
        },
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                transperent: "transperent",
                current: "currentColor",
                muted: "#94989a",
                white: "#ffffff",
                light: "#e2e6eb",
                black: "#323a46",
                purple: "#6a69f5",
                success: "#50cd89",
                danger: "#f1416c",
                warning: "#ffc700",
                info: "#009ef7",
                dark: "#151515",
                darklight: "#1F1F1F",
                darkborder: "#343331",
                darkmuted: "#767273",
            },
        },
    },

    plugins: [
        forms,
        typography,
        require("@tailwindcss/forms")({
            strategy: "base", // only generate global styles
        }),
        require("tailwind-scrollbar"),
        require("./resources/plugins/layouts/layouts"),
        require("./resources/plugins/layouts/sidebar"),
        require("./resources/plugins/card"),
        require("./resources/plugins/buttons"),
        require("./resources/plugins/forms"),
        require("./resources/plugins/tables"),
        require("./resources/plugins/plugins/flatpicker"),
        require("./resources/plugins/plugins/apexchart"),
    ],
};
