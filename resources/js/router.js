import Vue from 'vue'
import VueRouter from 'vue-router'

import LandingComponent from './components/LandingComponent.vue'
import SigninComponent from './components/SigninComponent.vue'
import RegistrationComponent from './components/RegistrationComponent.vue'
import ScaffoldComponent from './components/ScaffoldComponent.vue'
import NotificationsComponent from './components/NotificationComponent.vue'

import UnauthenticatedComponent from './components/UnauthenticatedComponent.vue'
import NotFoundComponent from './components/NotFoundComponent.vue'

import DashboardComponent from './components/administrator/DashboardComponent.vue'
import OrdersComponent from './components/administrator/OrdersComponent.vue'
import ProductsComponent from './components/administrator/ProductsComponent.vue'
import ProductCategoriesComponent from './components/administrator/ProductCategoriesComponent.vue'
import CustomersComponent from './components/administrator/CustomersComponent.vue'
import DeliveryFeeComponent from './components/administrator/DeliveryFeeComponent.vue'
import AdministratorProfile from './components/administrator/ProfileComponent.vue'

import MenuComponent from './components/customer/MenuComponent.vue'
import CheckoutComponent from './components/customer/CheckoutComponent.vue'
import CustomerOrderComponent from './components/customer/OrdersComponent.vue'
import ProfileComponent from './components/customer/ProfileComponent.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'landing',
        component: LandingComponent
    },
    {
        path: '/register',
        name: 'register',
        component: RegistrationComponent
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
            { path: '/a/orders', name: 'orders', components: { default: OrdersComponent }, props: { code: null } },
            { path: '/a/products', name: 'products', components: { default: ProductsComponent } },
            { path: '/a/productCategories', name: 'productCategories', components: { default: ProductCategoriesComponent } },
            { path: '/a/customers', name: 'customers', components: { default: CustomersComponent } },
            { path: '/a/deliveryFees', name: 'deliveryFees', components: { default: DeliveryFeeComponent } },
            { path: '/a/notifications', name: 'administratorNotifications', components: { default: NotificationsComponent } },
            { path: '/a/profile', name: 'administratorProfile', components: { default: AdministratorProfile } },
        ]
    },
    {
        path: '/c',
        name: 'customer',
        component: ScaffoldComponent,
        children: [
            { path: '/c/menu', name: 'menu', components: { default: MenuComponent } },
            { path: '/c/checkout', name: 'checkout', components: { default: CheckoutComponent } },
            { path: '/c/orders', name: 'customerOrders', components: { default: CustomerOrderComponent }, props: { code: null }  },
            { path: '/c/profile', name: 'profile', components: { default: ProfileComponent } },
            { path: '/c/notifications', name: 'customerNotifications', components: { default: NotificationsComponent } },
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
    landing: true, signin: true, register: true,

    // Administrator
    dashboard: true, orders: true, products: true, orders: true, productCategories: true, customers: true, deliveryFees: true, administratorNotifications: true, administratorProfile: true,
    // Customer
    menu: true, checkout: true, customerOrders: true, profile: true, customerNotifications: true,

    // Status
    404: true, 401: true,
}

const modulePermissions = {
    administrator: {
        ...modules,
        default: 'dashboard',
        landing: false, signin: false,
        menu: false, checkout: false, customerOrders: false, profile: false, customerNotifications: false,
    },
    customer: {
        ...modules,
        default: 'menu',
        landing: false, signin: false,
        dashboard: false, orders: false, products: false, orders: false, productCategories: false, customers: false, deliveryFees: false, administratorNotifications: false, administratorProfile: false,
    },
    unauthenticated: {
        ...modules,
        default: 'signin',
        dashboard: false, orders: false, products: false, orders: false, productCategories: false, customers: false, deliveryFees: false, administratorNotifications: false, administratorProfile: false,
        menu: false, checkout: false, customerOrders: false, profile: false, customerNotifications: false,
    }
}

router.beforeEach((to, from, next) => {
    let userRole = sessionStorage.getItem('userRole') ?? 'unauthenticated';

    if (!modulePermissions[userRole.toLocaleLowerCase()][to.name]) {
        next({ name: modulePermissions[userRole.toLocaleLowerCase()]['default'] })
    } else next()
})

export default router
