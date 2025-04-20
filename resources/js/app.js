import '../css/app.css';
import '../css/images.css';
import './bootstrap';

import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h, watch } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import MainLayout from '@/Layouts/MainLayout.vue';
import i18n from './i18n';

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

        const initialLocale = props.initialPage.props.locale;
        if (i18n.global.locale.value !== initialLocale) {
            i18n.global.locale.value = initialLocale;
        }

        router.on('navigate', (event) => {
            const newLocale = event.detail.page.props.locale;
            if (i18n.global.locale.value !== newLocale) {
                i18n.global.locale.value = newLocale;
            }
        });

        return app.mount(el);
    },
    progress: {
        color: '#1D9E1D',
    },
});
