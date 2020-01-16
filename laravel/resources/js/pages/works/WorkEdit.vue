<template>
  <div class="p-work-create">
    <div class="MainLayout">
      <h1 class="MainLayout_heading">募集案件編集フォーム</h1>
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <WorkFormLayout
            :form-data="formData"
            @workSubmit="update"
            @onRadioCheck="clearSkill"
          ></WorkFormLayout>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
// mixins
import workFormData from '@/mixins/formData/workFormData'
// other
import { mapState } from 'vuex'
import { OK, UNPROCESSABLE_ENTITY, BASE_STORAGE_URL } from '@/util'

import WorkFormLayout from '@/layouts/WorkFormLayout'

export default {
  components: {
    WorkFormLayout,
  },
  mixins: [workFormData],
  props: {
    work: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  data() {
    return {
      test: '',
    }
  },
  computed: {
    ...mapState({
      customer: state => state.auth.customer,
    }),
    isLogin() {
      return !!this.customer
    },
    binded() {
      return 'is_owner' in this.work
    },
  },
  watch: {
    binded: {
      async handler(val) {
        if (val && this.work.is_owner) {
          await this.fetchProfessions()
          this.bindValue()
        } else if (val && !this.work.is_owner) {
          await this.$router.push('/not-found')
        }
      },
      immediate: true,
    },
    isLogin: {
      async handler(val) {
        if (!val) {
          this.$router.push('/login')
        }
      },
      immediate: true,
    },
  },
  methods: {
    async update() {
      this.$store.commit('form/setIsLoading', true)

      const workData = new FormData()
      const keys = Object.keys(this.formData).filter(
        key => !!this.formData[key].value
      )
      keys.forEach(key => {
        workData.append(key, this.formData[key].value)
      })
      workData.append('customer_id', this.customer.id)
      workData.append('deleteFlag', this.formData.file_name.deleteFlag)
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
        `/api/works/${this.work.id}`,
        workData,
        config
      )

      this.$store.commit('form/setIsLoading', false)

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.$store.commit('error/setMessage', response.data.errors)
        this.$scrollTo('.Header', 1500)
        return false
      }
      if (response.status === OK) {
        this.$emit('fetchItem')
        this.$store.commit('error/setMessage', null)
        this.$store.commit('form/setSuccessMessage', '更新に成功しました')
      }
    },
    bindValue() {
      Object.keys(this.formData).forEach(key => {
        if (key === 'file_name') {
          this.formData[key].srcPath = this.work.file_name
            ? `${BASE_STORAGE_URL}/${this.work.file_name}`
            : null
        } else if(key === 'skill_types'){
          this.formData[key].value = this.work.skills.map( skill => skill.id )
          this.fetchSelectables()
        } else {
          this.formData[key].value = this.work[key]
        }
      })
    },
    async fetchSelectables(){
      const response = await axios.get(`/api/professions/${this.work.profession_type_id}/selectables`)
      this.$store.commit('form/setResponse', response)
      if(response.status !== OK){
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response.data.errors,
        })
      }else{
        this.formData.skill_types.list = response.data
      }
    },
    async clearSkill(id){
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
