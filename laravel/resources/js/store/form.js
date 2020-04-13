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
  targetSkills: [],
  currentPrefecture: 0,
  searchingSkill: []
}

const getters = {
  address: state => state.address,
  successMessage: state => state.successMessage,
  deleteMessage: state => state.deleteMessage,
  isLoading: state => state.isLoading,
  confirmModal: state => state.confirmModal,
  targetSkills: state => state.targetSkills,
  currentPrefecture: state => state.currentPrefecture,
  searchingSkill: state => state.searchingSkill,
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
  setTargetSkills(state, data) {
    state.targetSkills = data
  },
  setCurrentPrefecture(state, data) {
    state.currentPrefecture = data
  },
  setSearchingSkill(state, data) {
    state.searchingSkill = data
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
