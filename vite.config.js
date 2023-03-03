import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import topLevelAwait from "vite-plugin-top-level-await";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        topLevelAwait({
            // The export name of top-level await promise for each chunk module
            promiseExportName: "__tla",
            // The function to generate import names of top-level await promise in each chunk module
            promiseImportName: (i) => `__tla_${i}`,
        }),
    ],
});
