import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

let assetFiles = [
    'resources/css/before-head-end.css',
    'resources/js/before-head-end.js',
];
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...assetFiles,
            ],
            refresh: [
                ...refreshPaths,
                'resources/js/vendor/filament/**',
                'app/Http/Livewire/**',
                'app/Tables/Columns/**',
            ],
        }),
    ],
})
