import { OK, CREATED, UNPROCESSABLE_ENTITY } from '@/util'

const state = {
  apiStatus: null,
  responseData: null,
  address: null,
}

const getters = {
  address: state => state.address,
}


const mutations = {
  setResponse(state, data) {
    state.responseData = data
  },
  setAddress(state, data) {
    state.address = data
  },
}

const actions = {

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
