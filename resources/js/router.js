import Vue from 'vue'
import VueRouter from 'vue-router'

import LandingComponent from './components/LandingComponent.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/sample',
        name: 'landing',
        component: LandingComponent
    },
];

const opts = {
    mode: 'history',
    routes
}

export default new VueRouter(opts)
