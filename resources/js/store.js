import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        cart: [
            {
                id: 1,
                image:
                    "https://www.tasteofhome.com/wp-content/uploads/2020/03/Smash-Burgers_EXPS_TOHcom20_246232_B10_06_10b.jpg",
                name: "Burger",
                description: "The Delicious Burger",
                price: 100,
                quantity: 1,
            },
            {
                id: 2,
                image:
                    "https://www.sprinklesandsprouts.com/wp-content/uploads/2021/05/Peri-Peri-Fries-SQ.jpg",
                name: "Fries",
                description: "The Delicious Fries",
                price: 100,
                quantity: 2,
            },
            {
                id: 3,
                image:
                    "https://www.lanascooking.com/wp-content/uploads/2012/06/coke-floats-feature.jpg",
                name: "Coke Float",
                description: "The Delicious Coke Float",
                price: 100,
                quantity: 3,
            },
            {
                id: 4,
                image:
                    "https://a7m3f5i5.rocketcdn.me/wp-content/uploads/2015/09/moms-spaghetti-sauce-recipe-a-healthy-slice-of-life-6-of-6-800x600.jpg",
                name: "Spaghetti",
                description: "The Delicious Spaghetti",
                price: 100,
                quantity: 4,
            },
        ],
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
