import "./bootstrap";
import "../css/app.css";
import "remixicon/fonts/remixicon.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import PrimeVue from "primevue/config";
import { useDark } from "@vueuse/core";
import ConfirmationService from "primevue/confirmationservice";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const isDark = useDark();

isDark.value
    ? import("primevue/resources/themes/aura-dark-blue/theme.css")
    : import("primevue/resources/themes/aura-light-blue/theme.css");

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(ConfirmationService)
            .use(PrimeVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
