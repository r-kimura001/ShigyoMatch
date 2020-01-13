const state = {
  message: null,
  status: null
}

const mutations = {
  setMessage(state, data){
    state.message = data
  },
  setStatus(state, data){
    state.status = data
  },
  setErrors(state, data){
    state.message = data.message
    state.status = data.status
  },
}

const getters = {
  status: state => state.status,
  message: state => state.message,
}

const actions = {
  errorHandle (context, data) {
    context.commit('setErrors', data)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
