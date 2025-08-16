import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Admin-specific assets (standalone)
                "resources/css/admin.css",
                "resources/js/admin.js", 
                // Customer-specific assets (standalone)
                "resources/css/customer.css",
                "resources/js/customer.js"
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
