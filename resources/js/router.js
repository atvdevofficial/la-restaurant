import Vue from 'vue'
import VueRouter from 'vue-router'

import LandingComponent from './components/LandingComponent.vue'
import ScaffoldComponent from './components/ScaffoldComponent.vue'
import DashboardComponent from './components/DashboardComponent.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'landing',
        component: LandingComponent
    },
    {
        path: '/scaffold',
        name: 'scaffold',
        component: ScaffoldComponent,
        children: [
            { path: '/dashboard', name: 'dashboard', components: { default: DashboardComponent } }
        ]
    }
];

const opts = {
    mode: 'history',
    routes
}

export default new VueRouter(opts)
