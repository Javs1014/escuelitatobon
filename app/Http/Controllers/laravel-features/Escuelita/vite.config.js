import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // <-- AÑADE ESTO

export default defineConfig({
    plugins: [
        laravel({
            // ESTA LÍNEA ES LA IMPORTANTE
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            // Esto le dice a Vite dónde encontrar Bootstrap
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    }
});