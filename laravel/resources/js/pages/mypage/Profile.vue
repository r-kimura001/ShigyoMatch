<template>
  <div class="p-profiles">
    <div>
      <h2>Profile</h2>
      <section class="MypageContent_box">
        <h3>プロフィールの編集</h3>
        <ProfileFormLayout
          :form-data="formData"
          @profileSubmit="update"
        ></ProfileFormLayout>
      </section>
    </div>
  </div>
</template>
<script>
// components
import ProfileFormLayout from '@/layouts/mypage/ProfileFormLayout'
// mixins
import customerUpdateData from '@/mixins/formData/customerUpdateData'
// other
import { BASE_STORAGE_URL, OK, UNPROCESSABLE_ENTITY } from '@/util'

export default {
  components: { ProfileFormLayout },
  mixins: [customerUpdateData],
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  data() {
    return {
      professionTypes: null,
      prefectures: null,
      test: [],
    }
  },
  watch: {
    // routeを監視してページが切り替わったときにfetchList()が実行されるよう記述
    // さらにimmediate: true にしているのでコンポーネントが生成されたタイミングでも実行される
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.fetchProfessions()
        await this.fetchPrefectures()
        await this.bindCustomerData()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async fetchProfessions() {
      const response = await axios.get(`/api/professions`)
      if (response.status === OK) {
        this.formData.profession_types.list = response.data
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
          this.formData[key].srcPath = this.customer.file_name
            ? `${BASE_STORAGE_URL}/${this.customer.file_name}`
            : null
        } else {
          this.formData[key].value = this.customer[key]
        }
      })
    },
    async update() {
      this.$store.commit('form/setIsLoading', true)

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
        `/api/customers/${this.customer.id}`,
        customerData,
        config
      )

      this.$store.commit('form/setIsLoading', false)

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.$store.commit('error/setMessage', response.data.errors)
        this.$scrollTo('.Header', 1500)
        return false
      } else if (response.status === OK) {
        this.$store.commit('error/setMessage', null)
        this.$store.commit('auth/setCustomer', response.data)
        this.$store.commit('form/setSuccessMessage', '更新に成功しました')
      }
    },
  },
}
</script>
