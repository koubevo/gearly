import '../css/app.css';
import '../css/images.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import MainLayout from '@/Layouts/MainLayout.vue';
import i18n from './i18n';
import { usePage } from '@inertiajs/vue3';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} | ${appName}`,
    resolve: async (name) => {
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        );
        page.default.layout ??= MainLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n);

        setTimeout(() => {
            const page = usePage();
            const userLang = page.props.auth?.user?.lang;
            //TODO: default lang
            const savedLanguage = userLang || localStorage.getItem("userLanguage") || "en";

            i18n.global.locale.value = savedLanguage;
        }, 0);

        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
