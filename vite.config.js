import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    css: {
        devSourcemap: true,
    },
    server: {
        https: false,
        host: true,
        strictPort: true,
        port: 5191,
        hmr: {
            host: "localhost",
            protocol: "ws",
        },
        watch: {
            usePolling: true,
        },
    },
});
