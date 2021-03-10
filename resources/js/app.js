require('./bootstrap');
import Vue from 'vue'

// Components
import './components'

// Plugins
import './plugins'
import { sync } from 'vuex-router-sync'

// Application imports
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify.js'

// Sync store with router
sync(store, router)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
    vuetify,
    router,
    store,
}).$mount('#app')
