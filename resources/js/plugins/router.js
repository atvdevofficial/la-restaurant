import Vue from 'vue'
import VueRouter from 'vue-router'

import Example from '../components/ExampleComponent.vue'

Vue.use(VueRouter)

const routes = [
    { 
        path: '/',
        name: 'example',
        component: Example
    },
]

const opts = {
    mode: 'history', 
    routes
}

export default new VueRouter(opts)