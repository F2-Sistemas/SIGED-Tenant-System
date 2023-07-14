import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue';
import path from 'path'
import * as dotenv from 'dotenv'
dotenv.config()

let assetFiles = [
    'resources/css/before-head-end.css',
    'resources/js/before-head-end.js',
];

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@vendor': path.resolve(__dirname, 'vendor'),
            '@resources': path.resolve(__dirname, 'resources'),
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/app-tailwindcss.css',
                'resources/js/VueApp.js',
                'resources/js/app.js',
                'resources/js/before-head-end.js',
                'resources/js/vendor/filament/after-head.end-hook.js',
                ...assetFiles,
            ],
            ssr: 'resources/js/ssr.js',
            refresh: [
                ...refreshPaths,
                'resources/js/vendor/filament/**',
                'app/Http/Livewire/**',
                'app/Tables/Columns/**',
                'resources/views/components/**/**/**/*.blade.php',
                'resources/views/components/siged/orcamento-items/**/*.blade.php',
            ],
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
    server: {
        port: 5173,
        // origin: 'http://siged.local:8000',
        host: 'siged.local',
        cors: {
            origin: "*",
            methods: "GET,HEAD,PUT,PATCH,POST,DELETE",
            preflightContinue: false,
            optionsSuccessStatus: 204
        },
    }
})
