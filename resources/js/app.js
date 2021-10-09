/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import * as VueGoogleMaps from 'vue2-google-maps';
import { BootstrapVue } from 'bootstrap-vue';

require('./bootstrap');

/**
 * Register google maps with api key coming from .env
 */
Vue.use(VueGoogleMaps, {
    load: {
        key: process.env.MIX_GOOGLE_MAPS_API_KEY,
        libraries: 'places',
    },
    installComponents: true,
});

/*
 * Register bootstrap vue
 * */
Vue.use(BootstrapVue)

/**
 * Registers all vue components inside of ./components
 */
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    data() {
        return {
            currentUser: window.currentUser || null,
            currentLocation: null,
        }
    },
    el: '#app',
});


/**
 * Sidebar fix
 */

const openSidebar = () => {
    document.body.className = 'sidebar-show';
};

const closeSidebar = (e) => {
    if (e.target.className === 'sidebar-show')
        document.body.className = 'sidebar-gone';
}

const responsiveSidebar = () => {
    const newWidth = window.outerWidth;
    document.body.className = (
        newWidth > 1024
            ? ''
            : 'sidebar-gone'
    );
}

const sideBarButton = document.querySelector('[data-toggle="sidebar"]');
sideBarButton.addEventListener('click', openSidebar);

const sidebarBg = document.querySelector('body');
sidebarBg.addEventListener('click', closeSidebar);

window.addEventListener('load', responsiveSidebar);
window.addEventListener('resize', responsiveSidebar);
