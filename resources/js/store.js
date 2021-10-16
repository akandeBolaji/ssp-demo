import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        flashMessage: {
            status: false,
            title: false,
            message: false
        }
    }
})
