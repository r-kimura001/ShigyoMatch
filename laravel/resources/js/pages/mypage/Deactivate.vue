<template>
  <div class="p-deactivate">
    <section class="MypageContent_box">
      <h3 class="BaseTitle">
        <span class="BaseTitle_text">退会</span>
      </h3>
      <FormLayout
        :form-data="formData"
        :submit-button-data="submitButtonData"
        @send="deactivateEvent"
      ></FormLayout>
    </section>
  </div>
</template>
<script>
  import { OK, UNPROCESSABLE_ENTITY } from '@/util'
  import { mapGetters } from 'vuex'
  import FormLayout from '@/layouts/FormLayout.vue'

  export default {
    components: { FormLayout },
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({}),
      },
    },
    data() {
      return {
        formData: {
          password: {
            name: 'password',
            type: 'password',
            value: '',
            placeholder: 'パスワード(半角8ケタ以上)',
            options: {
              required: true
            }
          }
        },
        submitButtonData: {
          text: '退会する',
          class: '--danger'
        }
      }
    },
    computed: {
      ...mapGetters({
        apiStatus: 'auth/apiStatus',
      }),
    },
    methods: {
      async deactivateEvent() {
        if (!confirm('退会します。よろしいですか？')) {
          return false
        }

        this.$store.commit('form/setIsLoading', true)

        const formData = new FormData()
        formData.append('password', this.formData.password.value)
        formData.append('customer_id', this.customer.id)
        const response = await axios.post('/api/deactivate', formData)
        if (response.status === OK) {
          await this.$store.dispatch('auth/logout')
          if (this.apiStatus) {
            this.$store.commit('form/setIsLoading', false)
            this.$router.push('/deactivated')
          }
        }

        this.$store.commit('form/setIsLoading', false)
        if (response.status === UNPROCESSABLE_ENTITY) {
          this.$store.commit('error/setMessage', response.data.errors)
        } else {
          this.$store.commit('error/setStatus', response.status)
          this.$store.commit('setResponse', response)
        }
      }
    }
  }
</script>
