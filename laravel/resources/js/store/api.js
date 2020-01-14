import { OK, CREATED, UNPROCESSABLE_ENTITY } from '@/util'

const state = {
  paramPath: '',
}

const getters = {
  paramPath: state => state.paramPath,
}

const mutations = {
  setParamPath(state, data) {
    state.paramPath = data
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
