<template>
  <div class="p-works">
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <h2 class="BaseTitle --vertical">
            <span class="BaseTitle_text">
              再設定用のパスワードを設定してください
            </span>
          </h2>
          <p v-if="!!alertMsg" class="Text -success">{{ alertMsg }}</p>
          <FormLayout
            :form-data="formData"
            :submit-button-data="submitButtonData"
            @send="resetPassword"
          ></FormLayout>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
  import FormLayout from '@/layouts/FormLayout'
  import { OK, UNPROCESSABLE_ENTITY } from "@/util"
  import { mapGetters } from 'vuex'

  export default {
    components: { FormLayout },
    data() {
      return {
        formData: {
          password: {
            type: 'password',
            name: 'password',
            value: '',
            placeholder: 'PASSWORD(at least 8chars)',
            options: {
              required: true,
            },
          },
          password_confirmation: {
            type: 'password',
            name: 'password_confirmation',
            value: '',
            placeholder: 'PASSWORD(confirm)',
            options: {
              required: true,
            },
          },
        },
        submitButtonData: {
          text: '再設定',
        },
        alertMsg: null,
        test: null
      }
    },
    computed: {
      ...mapGetters({
        apiStatus: 'auth/apiStatus',
        customerId: 'auth/customerId'
      }),
      queries() {
        return this.$route.query
      },
    },
    methods: {
      async resetPassword(){
        this.$store.commit('form/setIsLoading', true)
        const params = new FormData()
        params.append('email', this.$route.query.email)
        params.append('token', this.$route.query.token)
        Object.keys(this.formData).forEach( key => {
          params.append(key, this.formData[key].value)
        })
        // パスワードリセットのメール送信APIを実行する
        const response = await axios.post('/api/password/reset', params)
        this.test = response
        this.$store.commit('form/setIsLoading', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
          this.$store.commit('error/setMessage', response.data.errors)
          return false
        }
        if (response.status === OK) {
          this.alertMsg = response.data.message
          setTimeout( () => {
            this.$router.push('/login')
          }, 3000)
        }
      }
    }

  }
</script>
