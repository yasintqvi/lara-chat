import authService from "@/services/authService";
import { createStore } from "vuex";

export default createStore({
    state: {
        user: null,
        isAuthenticated: false
    },

    getters: {
        user(state) {
            return state.user
        },

        isAuthenticated(state) {
            return state.isAuthenticated
        }
    },

    mutations: {
        setUser(state, user) {
            state.user = user
            state.isAuthenticated = true
        },

        cleanUser(state) {
            state.user = null
            state.isAuthenticated = false
        }
    },

    actions: {
        login({ commit }, user) {
            setTimeout(() => {
                commit('setUser', user)
            }, 1000)
        },

        logout({ commit }) {
            commit('cleanUser')
        }
    }
})