/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


Vue.prototype.authorize = function (handler) {
    let user = window.App.user;

    return user ? handler(user) : false;
};

window.events = new Vue();

window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level});
};


Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('thread-view', require('./pages/Thread.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
