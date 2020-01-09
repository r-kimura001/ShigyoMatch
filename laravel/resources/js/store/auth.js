import { OK, CREATED, UNPROCESSABLE_ENTITY } from '@/util'

const state = {
  customer: null,
  admin: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null,
  responseData: null,
  address: null,
}

const getters = {
  isLogin: state => !!state.customer,
  isAdmin: state => !!state.admin,
  customerName: state => (state.customer ? state.customer.name : ''),
  customerId: state => (state.customer ? state.customer.id : ''),
}


const mutations = {
  setCustomer(state, customer) {
    state.customer = customer
  },
  setApiStatus(state, status) {
    state.apiStatus = status
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages
  },
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages
  },
  setResponse(state, data) {
    state.responseData = data
  },
  setAddress(state, data) {
    state.address = data
  },
}

const actions = {
  // 会員登録
  async register(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/register', data)
    // context.commit('setResponse', response)

    if (response.status === CREATED) {
      context.commit('setApiStatus', true)
      context.commit('setCustomer', response.data)
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setRegisterErrorMessages', response.data.errors)
    } else {
      context.commit('error/setStatus', response.status, { root: true })
    }
  },

  // ログイン
  async login(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/login', data)

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setCustomer', response.data)
      context.commit('setLoginErrorMessages', null)
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setLoginErrorMessages', response.data.errors)
    } else {
      context.commit('error/setStatus', response.status, { root: true })
      context.commit('setResponse', response)
    }
  },

  // ログアウト
  async logout(context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setCustomer', null)
      context.commit('error/setStatus', response.status, { root: true })
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('setResponse', response)
    context.commit('error/setStatus', response.status, { root: true })
  },

  // ログインユーザーチェック
  async currentCustomer(context) {
    context.commit('setApiStatus', null)
    const response = await axios.get('/api/customer')
    const customer = response.data || null

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setCustomer', customer)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setStatus', response.status, { root: true })
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
