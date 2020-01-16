<template>
  <div class="p-work-create">
    <div class="MainLayout">
      <h1 class="MainLayout_heading">募集案件投稿フォーム</h1>
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <WorkFormLayout
            :form-data="formData"
            @workSubmit="store"
            @onRadioCheck="fetchSkill"
          ></WorkFormLayout>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import WorkFormLayout from '@/layouts/WorkFormLayout'
// mixins
import workFormData from '@/mixins/formData/workFormData'
// other
import { mapState } from 'vuex'
import { CREATED, UNPROCESSABLE_ENTITY, OK } from '@/util'

export default {
  components: {
    WorkFormLayout,
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.fetchProfessions()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  computed: {
    ...mapState({
      customer: state => state.auth.customer,
    }),
  },
  mixins: [workFormData],
  methods: {
    async store() {
      this.$store.commit('form/setIsLoading', true)

      const workData = new FormData()
      const keys = Object.keys(this.formData).filter(
        key => !!this.formData[key].value
      )
      keys.forEach(key => {
        workData.append(key, this.formData[key].value)
      })
      workData.append('customer_id', this.customer.id)

      const response = await axios.post(`/api/works/store`, workData)
      this.$store.commit('form/setIsLoading', false)

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.$store.commit('error/setMessage', response.data.errors)
        this.$scrollTo('.Header', 1500)
        return false
      }
      if (response.status === CREATED) {
        this.errorMessages = null
        this.clearFormValue()
        this.$store.commit('form/setDeleteReview', true)
        this.$store.commit('form/setSuccessMessage', '投稿に成功しました')
      }
    },
    fetchProfessions() {
      this.formData.profession_type_id.list = this.customer.profession_types
    },
    async fetchSkill(id){
      this.formData.skill_types.value = []
      const response = await axios.get(`/api/professions/${id}/selectables`)
      this.$store.commit('form/setResponse', response)
      if(response.status !== OK){
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response.data.errors,
        })
      }else{
        this.formData.skill_types.list = response.data
      }
    }
  },
}
</script>
