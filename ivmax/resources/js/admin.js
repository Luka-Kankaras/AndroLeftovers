window.Popper = require("popper.js").default;
window.$ = window.jQuery = require("jquery");

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

require("bootstrap");
require("admin-lte");

import Vue from "vue";
window.Vue = Vue;
window.Bus = new Vue();

import VueRouter from "vue-router";
Vue.use(VueRouter);

Vue.mixin({ methods: { route } });

import router from "@/router";
const App = () => import(/* webpackChunkName: "cms-app" */ "@admin/App");

import TinyMce from '@tinymce/tinymce-vue'
import VueMce from 'vue-mce';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('short', (value) => {
    return value.length > 50 ? value.substring(0, 50) + '...' : value;
});

// strip html tags
Vue.filter('stripHTML', function (value) {
    const div = document.createElement('div');
    div.innerHTML = value;
    return div.textContent || div.innerText || '';
});

// Truncate
Vue.filter("truncate", function (value, limit) {
    if (!value) return "";
    value = value.toString();

    return value && value.length > limit
        ? value.substring(0, limit) + "..."
        : value;
});

Vue.use(TinyMce);
Vue.use(VueMce);

const app = new Vue({
    el: "#app",
    router,
    render(h) {
        return h(App);
    }
});
