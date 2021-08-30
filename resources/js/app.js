/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require("./bootstrap");

window.Vue = require("vue").default;
const VueRouter = require("vue-router").default;

const Foo = { template: "<div>foo</div>" };
const Bar = { template: "<div>bar</div>" };
const routes = [
    { path: "/admin", component: Foo },
    { path: "/foo", component: Foo },
    { path: "/bar", component: Bar }
];
const router = new VueRouter({
    routes // short for `routes: routes`
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "dashboard-component",
    require("./components/DashboardComponent.vue").default
);
Vue.component(
    "document-manager-component",
    require("./components/DocumentManagerComponent.vue").default
);
Vue.component(
    "document-edit-component",
    require("./components/DocumentEditComponent.vue").default
);
Vue.component(
    "document-list-component",
    require("./components/DocumentListComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    el: "#app"
});
