<template>
  <div class="p-works">
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <h2 class="BaseTitle --vertical">
            <span class="BaseTitle_text">
              パスワード再設定のお手続
            </span>
          </h2>
          <p v-if="!!sentStatus" class="Text" :class="alertClass">{{ alertMsg }}</p>
          <FormLayout
            :form-data="formData"
            :submit-button-data="submitButtonData"
            @send="sendPasswordEmail"
          ></FormLayout>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
  import {OK, UNPROCESSABLE_ENTITY} from "@/util";
  import FormLayout from '@/layouts/FormLayout'
  export default {
    components: { FormLayout },
    data() {
      return {
        formData: {
          email: {
            type: 'email',
            name: 'email',
            value: '',
            placeholder: 'sample@example.com',
            options: {
              required: true,
            },
          },
        },
        test: null,
        sentStatus: null,
        submitButtonData: {
          text: '送信',
        },
        alertMsg: null
      }
    },
    computed: {
      alertClass () {
        const isInvalid = this.sentStatus === UNPROCESSABLE_ENTITY

        return isInvalid ? {
          '-danger': true
        } : {
          '-success': true
        }
      }
    },
    methods: {
      async sendPasswordEmail(){
        this.$store.commit('form/setIsLoading', true)
        const forgetPasswordData = new FormData()
        forgetPasswordData.append('email', this.formData.email.value)
        // パスワードリセットのメール送信APIを実行する
        const response = await axios.post('/api/password/email', forgetPasswordData)
        this.$store.commit('form/setIsLoading', false)
        this.test = response
        this.sentStatus = response.status
        if(response.status === UNPROCESSABLE_ENTITY) {
          this.$store.commit('error/setMessage', response.data.message)
          this.$scrollTo('.Header', 1500)
        }
        this.alertMsg = response.data.message
      }
    }

  }
</script>
