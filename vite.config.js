import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
//Added to solve the CORS(cross-over resources security)
    server: {
        hmr: {
            host: 'pizzaordersystem.local',
        },
        cors: true,
        host: 'pizzaordersystem.local',
        port: 5173,
    },
/*
    //Added this to solve the profile dropdown error
    server: {
        // Allows access from your local development domain
        origin: 'http://pizzaordersystem.local',
        host: true, // Needed to expose to network if using a specific IP/domain
    },
*/
});
