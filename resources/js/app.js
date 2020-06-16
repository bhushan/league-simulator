window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue = require('vue');

import VueI18n from 'vue-i18n';
import lang from './lang/en.json';

Vue.use(VueI18n);

Vue.component('league-table', require('./components/LeagueTable.vue').default);

let app = new Vue({
    el: '#app',
    i18n: new VueI18n({
        locale: 'en',
        fallbackLocale: 'en',
        messages: {
            en: lang.en,
        }
    }),
});

