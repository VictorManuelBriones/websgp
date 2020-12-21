/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Welcome
Vue.component('form-project-component', require('./components/welcome/FormProject.vue').default);
//layouts
Vue.component('site-masthead-component', require('./components/layouts/SiteMasthead.vue').default);
Vue.component('site-footer-component', require('./components/layouts/SiteFooter.vue').default);
Vue.component('site-contact-component', require('./components/layouts/SiteContact.vue').default);
Vue.component('site-about-component', require('./components/layouts/SiteAbout.vue').default);
Vue.component('site-services-component', require('./components/layouts/SiteServices.vue').default);
//Home
    //Admin
Vue.component('form-servicio-component', require('./components/home/admin/CreateServices.vue').default);
Vue.component('form-tipo-proyecto-component', require('./components/home/admin/CreateTypeProject.vue').default);
Vue.component('view-proyectos-component', require('./components/home/admin/ReadProjects.vue').default);
    //User
Vue.component('create-projects-component', require('./components/home/user/CreateProjects.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
