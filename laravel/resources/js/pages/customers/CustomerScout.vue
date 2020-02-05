<template>
  <div class="p-customer-scout">
    <div class="MainLayout">
      <h1 class="BaseTitle">
        <span class="BaseTitle_text --scout">{{ customer.name }}さんへのスカウト</span>
      </h1>
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <FormLayout
            :form-data="formData"
            :submit-button-data="submitButtonData"
            @send="scout()"
          ></FormLayout>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
  import FormLayout from '@/layouts/FormLayout'
  import scoutFormData from '@/mixins/formData/scoutFormData'
  import { CREATED, UNPROCESSABLE_ENTITY, OK } from "@/util"
  import { mapState } from "vuex"
  export default {
    components: { FormLayout },
    mixins: [ scoutFormData ],
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({})
      },
      paramPath: {
        type: String,
      }
    },
    data(){
      return {
        submitButtonData: {
          text: '上記の内容でスカウトする',
          class: {
            '--radius': true,
            '--pink': true
          },
        },
        test: null
      }
    },
    computed: {
      ...mapState({
        author: state => state.auth.customer
      }),
    },
    watch: {
      $route: {
        async handler(){
          this.$store.commit('form/setIsLoading', true)
          await this.fetchOwnerWorks()
          this.$store.commit('form/setIsLoading', false)
        },
        immediate: true
      }
    },
    methods: {
      async fetchOwnerWorks() {
        const response = await axios.get(`/api/customers/${this.author.id}/pageless_works`)
        if (response.status === OK) {
          this.formData.work_id.list = response.data
        }else{
          this.$store.commit('error/setErrors', {
            status: response.status,
            message: response.message,
          })
        }
      },
      async scout() {
        if(this.isScouted()){
          alert(`${this.customer.name}さんはこの案件でスカウト済みです`)
          return false
        }
        if(!confirm('スカウトします。よろしいですか？')){
          return false
        }
        this.$store.commit('form/setIsLoading', true)

        const scoutData = new FormData()
        const keys = Object.keys(this.formData).filter(
          key => !!this.formData[key].value
        )
        keys.forEach(key => {
          scoutData.append(key, this.formData[key].value)
        })
        scoutData.append('scouted_id', this.customer.id)

        const response = await axios.post(`/api/scout`, scoutData)

        this.$store.commit('form/setIsLoading', false)

        if (response.status === UNPROCESSABLE_ENTITY) {
          this.$store.commit('error/setMessage', response.data.errors)
          this.$scrollTo('.Header', 1500)
          return false
        } else if (response.status === CREATED) {
          this.$store.commit('error/setErrors', {
            message: null,
            status: null,
          })
          this.clearFormValue()
          this.$store.commit('form/setSuccessMessage', 'スカウトが完了しました')
          this.$router.push(`/mypage/${this.author.id}/scouts`)
        } else {
          this.$store.commit('error/setErrors', {
            message: response,
            status: response.status,
          })
        }
      },
      isScouted() {
        const workId = this.formData.work_id.value
        const target = this.formData.work_id.list.filter(work => work.id === workId)
        if (target[0].scouts.length > 0) {
          const result = target[0].scouts.filter(scoutedMember => scoutedMember.id === this.customer.id)
          return result.length === 1
        } else{
          return false
        }
      }
    }
  }
</script>
