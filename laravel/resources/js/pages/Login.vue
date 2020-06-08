<template>
  <div class="p-login">
    <div class="MainLayout --login">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div class="AuthFormLayout --login">
            <h2 class="AuthFormLayout_title">Log in</h2>
            <div class="Form --login">
              <form @submit.prevent="login">
                <div class="Form_row">
                  <div class="Form_errorBox">
                    <div v-if="hasError('login_id')">
                      <small
                        v-for="(errorMessage, index) in errorMessages.login_id"
                        :key="index"
                        class="ValidationErrorMessage"
                        >{{ errorMessage }}</small
                      >
                    </div>
                  </div>
                  <input
                    v-model="loginForm.login_id"
                    type="text"
                    class="Form_text --id"
                    placeholder="LOGIN ID"
                    autofocus
                    required
                  />
                </div>
                <div class="Form_row">
                  <div class="Form_errorBox">
                    <div v-if="hasError('password')">
                      <small
                        v-for="(errorMessage, index) in errorMessages.password"
                        :key="index"
                        class="ValidationErrorMessage"
                        >{{ errorMessage }}</small
                      >
                    </div>
                  </div>
                  <input
                    v-model="loginForm.password"
                    type="password"
                    class="Form_text"
                    placeholder="PASSWORD"
                    required
                  />
                  <div class="u-alignRight u-mt15">
                    <RouterLink to="/forgetpassword" tag="span" class="Text -link -fz12">パスワードをお忘れの方</RouterLink>
                  </div>
                </div>
                <div class="Form_row u-alignCenter">
                  <button class="Form_button --radius u-mt20">
                    Log in
                  </button>
                </div>
              </form>
            </div>
            <div class="HorizontalLayout --vertical --justifyCenter --smCol u-mt40">
              <div class="HorizontalLayout_col">
                <TwitterLoginButton></TwitterLoginButton>
              </div>
              <div class="HorizontalLayout_col u-ma20">
                <RouterLink to="/signup" tag="span" class="Text -link -signin -fz12">新規登録はこちら</RouterLink>
              </div>
            </div>
          </div>
        </section>
        <!-- MainLayout_box -->
      </div>
      <!-- MainLayout_boxList -->
    </div>
    <!-- MainLayout -->
  </div>
  <!-- p-login -->
</template>
<script>
  import TwitterLoginButton from '@/components/TwitterLoginButton'
import { mapState, mapGetters } from 'vuex'
export default {
    components: { TwitterLoginButton },
  data() {
    return {
      loginForm: {
        login_id: '',
        password: '',
      },
    }
  },
  watch: {
    $route: {
      handler(){
        this.$store.commit('auth/setLoginErrorMessages', null)
      },
      immediate: true
    }
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      errorMessages: state => state.auth.loginErrorMessages,
    }),
    ...mapGetters({
      customerId: 'auth/customerId',
    }),
  },
  methods: {
    hasError($prop) {
      return (
        this.errorMessages !== null &&
        Object.keys(this.errorMessages).indexOf($prop) >= -1
      )
    },

    async login() {
      this.$store.commit('form/setIsLoading', true)
      const formData = new FormData()
      formData.append('login_id', this.loginForm.login_id)
      formData.append('password', this.loginForm.password)
      await this.$store.dispatch('auth/login', formData)

      this.$store.commit('form/setIsLoading', false)

      if (this.apiStatus) {
        this.$router.push(`mypage/${this.customerId}`)
      }
    },
  },
}
</script>
