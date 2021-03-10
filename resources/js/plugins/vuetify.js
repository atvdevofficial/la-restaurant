import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@fortawesome/fontawesome-free/css/all.css'
import '@mdi/font/css/materialdesignicons.css'
import theme from './theme'
import VueFormulate from '@braid/vue-formulate'


Vue.use(Vuetify)

const opts = {
    icons: { iconfont: 'fa'},
    icons: { iconfont: 'mdi'},
    theme
}

export default new Vuetify(opts)
