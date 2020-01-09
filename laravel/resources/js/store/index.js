import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import form from './form'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    error,
    form,
  },
})

export default store
