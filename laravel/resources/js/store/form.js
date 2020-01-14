import { OK, CREATED, UNPROCESSABLE_ENTITY } from '@/util'

const state = {
  apiStatus: null,
  responseData: null,
  address: null,
  successMessage: null,
  deleteMessage: null,
  isLoading: false,
  deleteImageReview: false,
  confirmModal: {
    isShow: false,
    exeText: null
  },
}

const getters = {
  address: state => state.address,
  successMessage: state => state.successMessage,
  deleteMessage: state => state.deleteMessage,
  isLoading: state => state.isLoading,
  confirmModal: state => state.confirmModal,
}


const mutations = {
  setResponse(state, data) {
    state.responseData = data
  },
  setAddress(state, data) {
    state.address = data
  },
  setSuccessMessage(state, data) {
    state.successMessage = data
  },
  setDeleteMessage(state, data) {
    state.deleteMessage = data
  },
  setIsLoading(state, data) {
    state.isLoading = data
  },
  setDeleteReview(state, data) {
    state.deleteImageReview = data
  },
  setConfirmModal(state, data) {
    state.confirmModal.isShow = data.isShow
    state.confirmModal.exeText = data.exeText
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
