import Vue from 'vue'
import Vuex from 'vuex'

import createPersistedState from "vuex-persistedstate"

Vue.use(Vuex)

const store = new Vuex.Store({
    plugins: [createPersistedState()],
    state: {
        cart: [],
    },
    getters: {
        cart(state) {
            return state.cart
        },
        cartSubTotal(state) {
            return state.cart.reduce((accumulator, currentValue) => Number(accumulator) + (Number(currentValue.quantity) * Number(currentValue.price)), 0.0)
        },
        cartItemsCount(state) {
            return state.cart.length
        }
    },
    mutations: {
        addCartProduct(state, payload) {
            var productExists = false;

            // Check if product already exists
            state.cart.forEach(product => {
                if (product.id == payload.id) {
                    product.quantity += 1;
                    productExists = true;
                }
            })

            // If product doesnt exists
            if (!productExists) {
                state.cart.push({ ...payload, quantity: 1 })
            }
        },

        updateCartProduct(state, payload) {
            if (state.cart.includes(payload.original)) {
                var index = state.cart.indexOf(payload.original)
                state.cart[index].quantity = payload.updated.quantity
            }
        },

        removeCartProduct(state, payload) {
            if (state.cart.includes(payload)) {
                var index = state.cart.indexOf(payload)
                state.cart.splice(index, 1)
            }
        },

        clearCartItems(state) {
            state.cart = []
        }
    },
    actions: {
        addCartProduct(context, payload) {
            context.commit('addCartProduct', payload)
        },

        updateCartProduct(context, payload) {
            context.commit('updateCartProduct', payload)
        },

        removeCartProduct(context, payload) {
            context.commit('removeCartProduct', payload)
        },

        clearCartItems(context) {
            context.commit('clearCartItems')
        }
    }
})

export default store
