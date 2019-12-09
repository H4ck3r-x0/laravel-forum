/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import InstantSearch from 'vue-instantsearch';

window.Vue = require('vue');
Vue.use(InstantSearch);


let authorizations = require('./authorizations');

Vue.prototype.authorize = function (...params) {
    if (! window.App.signdIn) return false;

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
};

Vue.prototype.signdIn = window.App.signdIn;

window.events = new Vue();

window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level});
};


Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('thread-view', require('./pages/Thread.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('search', require('./components/Search.vue').default);
Vue.component('trix-vue', require('./components/Trix.vue').default);
Vue.component('account-dropdown', require('./components/AccountDropdown.vue').default);
Vue.component('register', require('./components/Auth/Register').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
