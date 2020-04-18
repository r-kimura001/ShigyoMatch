<template>
  <div class="TwitterLoginButton" @click="twitterRedirect">
    Twitterでログイン
  </div>
</template>
<script>
  import { OK } from "@/util";

  export default {
    methods: {
      async twitterRedirect () {
        this.$store.commit('form/setIsLoading', true)
        const response = await axios.get('/api/auth/twitter')
        this.$store.commit('form/setIsLoading', false)
        if (response.status === OK) {
          window.location.href = response.data.redirect_url
        } else {
          this.$store.dispatch('error/setErrors', {
            status: response.status,
            message: response.data.message
          })
        }
      }
    }
  }
</script>
