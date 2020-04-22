<template>
  <div class="p-twitter-callback">
    <p v-if="attempting" class="callback-loading-message">Twitterアカウントでログイン中...</p>
    <div v-else>
      <p>Twitterでのログインに失敗しました。</p>
      <p>{{ failedMessage }}</p>
    </div>
  </div>
</template>

<script>
  import { CREATED } from "@/util"
  import { mapState, mapGetters } from 'vuex'
  export default {
    data () {
      return {
        failedMessage: null,
        test: null
      }
    },

    computed: {
      attempting () {
        return !this.failedMessage
      },
      ...mapGetters({
        customerId: 'auth/customerId',

      }),
    },
    ...mapState({
      customer: state => state.auth.customer,
    }),
    watch: {
      customer: {
        async handler(val) {
          if (val) {
            this.$router.push(`/mypage/${this.customer.id}`)
          }
        },
        immediate: true,
      },
    },
    async mounted () {
      try {
        const callbackData = await axios.get('/api/auth/twitter/callback', { params: this.$route.query })
        this.test = callbackData
        if (callbackData.status === CREATED) {
          this.$store.commit('auth/setApiStatus', true)
          this.$store.commit('auth/setCustomer', callbackData.data)
          this.$store.commit('auth/setRegisterErrorMessages', null)
          this.$router.push(`/mypage/${this.customerId}`)
        } else {
          this.$store.dispatch('error/errorHandle', {
            message: callbackData.data.message,
            status: callbackData.status
          })
        }
      } catch (error) {
        this.failedMessage = error.message
      }
    }
  }
</script>
