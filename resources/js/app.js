/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('codes-target-selector', require('./components/CodesTargetSelector.vue').default);

Vue.component('stats-browser', require('./components/StatsBrowser.vue').default);

Vue.component('stats-platform', require('./components/StatsPlatform.vue').default);

Vue.component('stats-device', require('./components/StatsDevice.vue').default);

Vue.component('stats-browser-type', require('./components/StatsBrowserType.vue').default);

Vue.component('stats-last-week', require('./components/StatsLastWeek.vue').default);

Vue.component('stats-last-month', require('./components/StatsLastMonth.vue').default);

Vue.component('stats-last-year', require('./components/StatsLastYear.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        codes : {
            targets: 1
        }
    },

    methods: {
        addTarget: function() {
            this.codes.targets += 1;
        },
        removeTarget: function() {
            if ( this.codes.targets > 1 ) {
                this.codes.targets -= 1;
            }
        }
    }
});
