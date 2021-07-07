import Vue from 'vue'
import VueRouter from 'vue-router'

import LandingComponent from './components/LandingComponent.vue'
import ScaffoldComponent from './components/ScaffoldComponent.vue'
import DashboardComponent from './components/administrator/DashboardComponent.vue'
import OrdersComponent from './components/administrator/OrdersComponent.vue'
import ProductsComponent from './components/administrator/ProductsComponent.vue'
import ProductCategoriesComponent from './components/administrator/ProductCategoriesComponent.vue'
import CustomersComponent from './components/administrator/CustomersComponent.vue'

import MenuComponent from './components/customer/MenuComponent.vue'
import CheckoutComponent from './components/customer/CheckoutComponent.vue'
import CustomerOrderComponent from './components/customer/OrdersComponent.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'landing',
        component: LandingComponent
    },
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
        ]
    }
];

const opts = {
    mode: 'history',
    routes
}

export default new VueRouter(opts)
