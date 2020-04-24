import Vue from 'vue'
import Vuex from 'vuex'
import { userInfo } from '@/api/user'
import { priceList } from '@/api/price'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user: null,
        loading: false,
        prices: []
    },
    mutations: {
        setUser (state, payload) {
			state.user = payload	
		},
        setLoading (state, payload) {
            state.loading = payload    
        },
        setPrices (state, payload) {
            state.prices = payload    
        }
    },
    actions: {
        loadUser ({commit}) {
            return new Promise((resolve, reject) => {
                commit('setUser', window.userInfo)
                resolve(window.userInfo);
                // userInfo().then(res => {
                //     commit('setUser', res.data)
                //     resolve(res.data);
                // }, error => {
                //     // http failed, let the calling function know that action did not work out
                //     reject(error);
                // })
            })
        },
        setUser ({commit}, payload) {
            commit('setUser', payload)
        },
        setLoading ({commit}, payload) {
            commit('setLoading', payload)
        },
        loadPrices ({commit}, payload) {
            priceList().then(res => {
                commit('setPrices', res.data)
            })
        },
    }, 
    getters: {
        user (state) {
			return state.user
		},
        loading (state) {
            return state.loading
        },
        prices (state) {
            return state.prices
        },
        price: (state) => (id) => {
            if (state.prices.length === 0) {
                return {}
            }
            return state.prices.find(price => price.id == id)
        
        }
    }
})