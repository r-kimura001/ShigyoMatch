import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import form from './form'
import api from './api'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    error,
    form,
    api,
  },
})

export default store
