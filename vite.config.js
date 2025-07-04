import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css", // Ini sekarang akan mengimport Bootstrap CSS
                "resources/js/app.js", // Ini sekarang akan mengimport Bootstrap JS
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "~bootstrap": "node_modules/bootstrap",
        },
    },
});
