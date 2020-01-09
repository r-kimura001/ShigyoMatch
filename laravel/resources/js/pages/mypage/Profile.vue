<template>
  <div class="p-profiles">
    <Loader :class="{ '--show': isLoading }" />
    <section class="">
      <h1>Profile</h1>
      <ProfileFormLayout
        :form-data="formData"
        :error-messages="errorMessages"
        @profileSubmit="update"
      ></ProfileFormLayout>
    </section>
    <ResultMessage></ResultMessage>
  </div>
</template>
<script>
// components
import Loader from '@/components/Loader'
import ProfileFormLayout from '@/layouts/mypage/ProfileFormLayout'
import ResultMessage from '@/components/ResultMessage'
// mixins
import customerUpdateData from '@/mixins/formData/customerUpdateData'
// other
import { mapState } from 'vuex'
import { BASE_STORAGE_URL, OK, UNPROCESSABLE_ENTITY } from '@/util'

export default {
  components: { ProfileFormLayout, Loader, ResultMessage },
  mixins: [customerUpdateData],
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      professionTypes: null,
      prefectures: null,
      isLoading: false,
      test: [],
      errorMessages: {},
    }
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      customer: state => state.auth.customer,
    }),
  },
  watch: {
    // routeを監視してページが切り替わったときにfetchList()が実行されるよう記述
    // さらにimmediate: true にしているのでコンポーネントが生成されたタイミングでも実行される
    $route: {
      async handler() {
        this.isLoading = true
        await this.fetchProfessions()
        await this.fetchPrefectures()
        await this.bindCustomerData()
        this.isLoading = false
      },
      immediate: true,
    },
  },
  beforeCreate() {
    this.$store.dispatch('auth/currentCustomer')
  },
  methods: {
    boxChecked(id) {
      return {
        '--disable': this.customerData.professionIds.indexOf(id) === -1,
      }
    },
    hasError(prop) {
      return (
        this.errorMessages !== null &&
        Object.keys(this.errorMessages).indexOf(prop) >= -1
      )
    },
    async fetchProfessions() {
      const response = await axios.get(`/api/professions`)
      if (response.status === OK) {
        this.formData.profession_types.list = response.data
      }
    },
    async fetchPrefectures() {
      const response = await axios.get(`/api/prefectures`)
      if (response.status === OK) {
        this.formData.pref_code.list = response.data
      }
    },
    async bindCustomerData() {
      Object.keys(this.formData).forEach(key => {
        if (key === 'profession_types') {
          this.formData.profession_types.value = this.customer.profession_types.map(
            professionData => professionData.id
          )
          this.customer.profession_types.forEach(professionData => {
            this.formData.profession_types.registerNumbers[professionData.id] =
              professionData.pivot.register_number
          })
        } else if (key === 'email' || key === 'login_id') {
          this.formData[key].value = this.customer.user[key]
        } else if (key === 'file_name') {
          this.formData[
            key
          ].srcPath = `${BASE_STORAGE_URL}/${this.customer.file_name}`
        } else {
          this.formData[key].value = this.customer[key]
        }
      })
    },
    async update() {
      this.isLoading = true

      const customerData = new FormData()
      const keys = Object.keys(this.formData).filter(
        key => !!this.formData[key].value
      )
      keys.forEach(key => {
        if (key === 'profession_types') {
          customerData.append('professionIds', this.formData[key].value)
          customerData.append(
            'registerNumbers',
            JSON.stringify(this.formData[key].registerNumbers)
          )
        } else {
          customerData.append(key, this.formData[key].value)
        }
      })
      customerData.append('deleteFlag', this.formData.file_name.deleteFlag)

      /**
       * 一旦POSTで投稿、PUTに上書き
       */
      let config = {
        headers: {
          'content-type': 'multipart/form-data',
        },
      }
      config.headers['X-HTTP-Method-Override'] = 'PUT'

      const response = await axios.post(
        `/api/customers/${this.id}`,
        customerData,
        config
      )

      this.isLoading = false

      this.$store.commit('auth/setResponse', response)

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errorMessages = response.data.errors
        this.$scrollTo('.Header', 1500)
        return false
      }
      if (response.status === OK) {
        this.errorMessages = null
        this.$store.commit('auth/setCustomer', response.data)
        this.$scrollTo('.Header', 1500)
        this.$store.commit('form/setSuccessMessage', '更新に成功しました')
        setTimeout(() => {
          this.$store.commit('form/setSuccessMessage', null)
        }, 3000)
      }
    },
  },
}
</script>
