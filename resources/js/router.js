import Vue from 'vue'
import VueRouter from 'vue-router'

import LandingComponent from './components/LandingComponent.vue'
import SigninComponent from './components/SigninComponent.vue'
import ScaffoldComponent from './components/ScaffoldComponent.vue'
import UnauthenticatedComponent from './components/UnauthenticatedComponent.vue'
import NotFoundComponent from './components/NotFoundComponent.vue'

import DashboardComponent from './components/administrator/DashboardComponent.vue'
import OrdersComponent from './components/administrator/OrdersComponent.vue'
import ProductsComponent from './components/administrator/ProductsComponent.vue'
import ProductCategoriesComponent from './components/administrator/ProductCategoriesComponent.vue'
import CustomersComponent from './components/administrator/CustomersComponent.vue'

import MenuComponent from './components/customer/MenuComponent.vue'
import CheckoutComponent from './components/customer/CheckoutComponent.vue'
import CustomerOrderComponent from './components/customer/OrdersComponent.vue'
import ProfileComponent from './components/customer/ProfileComponent.vue'
import { toLower } from 'lodash'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'landing',
        component: LandingComponent
    },
    {
        path: '/signin',
        name: 'signin',
        component: SigninComponent
    },

    // Portal Components
    {
        path: '/a',
        name: 'administrator',
        component: ScaffoldComponent,
        children: [
            { path: '/a/dashboard', name: 'dashboard', components: { default: DashboardComponent } },
            { path: '/a/orders', name: 'orders', components: { default: OrdersComponent } },
            { path: '/a/products', name: 'products', components: { default: ProductsComponent } },
            { path: '/a/productCategories', name: 'productCategories', components: { default: ProductCategoriesComponent } },
            { path: '/a/customers', name: 'customers', components: { default: CustomersComponent } },
        ]
    },
    {
        path: '/c',
        name: 'customer',
        component: ScaffoldComponent,
        children: [
            { path: '/c/menu', name: 'menu', components: { default: MenuComponent } },
            { path: '/c/checkout', name: 'checkout', components: { default: CheckoutComponent } },
            { path: '/c/orders', name: 'customerOrders', components: { default: CustomerOrderComponent } },
            { path: '/c/profile', name: 'profile', components: { default: ProfileComponent } },
        ]
    },

    // Error Components
    {
        path: '/401',
        name: '401',
        component: UnauthenticatedComponent
    },
    {
        path: '/404',
        name: '404',
        component: NotFoundComponent
    },
];

const opts = {
    mode: 'history',
    routes
}

const router = new VueRouter(opts)

// Router Guards
const modules = {
    // Main
    landing: true, signin: true,

    // Administrator
    dashboard: true, orders: true, products: true, orders: true, productCategories: true, customers: true,
    // Customer
    menu: true, checkout: true, customerOrders: true, profile: true,

    // Status
    404: true, 401: true,
}

const modulePermissions = {
    administrator: {
        ...modules,
        default: 'dashboard',
        landing: false, signin: false,
        menu: false, checkout: false, customerOrders: false, profile: false,
    },
    customer: {
        ...modules,
        default: 'menu',
        landing: false, signin: false,
        dashboard: false, orders: false, products: false, orders: false, productCategories: false, customers: false,
    },
    unauthenticated: {
        ...modules,
        default: 'landing',
        dashboard: false, orders: false, products: false, orders: false, productCategories: false, customers: false,
        menu: false, checkout: false, customerOrders: false, profile: false,
    }
}

router.beforeEach((to, from, next) => {
    let userRole = sessionStorage.getItem('userRole') ?? 'unauthenticated';

    if (!modulePermissions[userRole.toLocaleLowerCase()][to.name]) {
        next({ name: modulePermissions[userRole.toLocaleLowerCase()]['default'] })
    } else next()
})

export default router
