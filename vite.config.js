import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Vite asset pipeline (app + marketplace + admin bundles)
 */

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/shop.css',
                'resources/js/app.js',
                'resources/js/shop.js',
            ],
            refresh: true,
        }),
    ],
});
