import Vue from 'vue'
import VueRouter from 'vue-router'

import LandingComponent from './components/LandingComponent.vue'
import ScaffoldComponent from './components/ScaffoldComponent.vue'
import DashboardComponent from './components/DashboardComponent.vue'
import OrdersComponent from './components/OrdersComponent.vue'
import ProductsComponent from './components/ProductsComponent.vue'

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
            { path: '/dashboard', name: 'dashboard', components: { default: DashboardComponent } },
            { path: '/orders', name: 'orders', components: { default: OrdersComponent } },
            { path: '/products', name: 'products', components: { default: ProductsComponent } },
        ]
    }
];

const opts = {
    mode: 'history',
    routes
}

export default new VueRouter(opts)
