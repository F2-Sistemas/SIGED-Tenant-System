import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Theme from '@/helpers/preferences/Theme';

import collect from 'collect.js';

window.collect = (collect.default);
window._Theme = new Theme();
window.addEventListener('load', (event) => {
    if (!window._Theme) {
        return
    }

    window._Theme.loadTheme(true, true);
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

import '../css/app-tailwindcss.css';
import '../css/vue-app/style.css';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
