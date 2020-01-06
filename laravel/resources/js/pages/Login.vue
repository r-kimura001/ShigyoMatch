<template>
  <div class="p-login">
    <Loader :class="{ '--show': isLoading }" />
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box u-mt50">
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
                </div>
                <div class="Form_row u-alignCenter">
                  <button class="Form_button u-mt20">
                    Log in
                  </button>
                </div>
              </form>
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
import { mapState, mapGetters } from 'vuex'
import Loader from '@/components/Loader'
export default {
  components: {
    Loader,
  },
  data() {
    return {
      loginForm: {
        login_id: '',
        password: '',
      },
      isLoading: false,
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
      this.isLoading = true
      const formData = new FormData()
      formData.append('login_id', this.loginForm.login_id)
      formData.append('password', this.loginForm.password)
      await this.$store.dispatch('auth/login', formData)

      this.isLoading = false

      if (this.apiStatus) {
        this.$router.push(`mypage/${this.customerId}`)
      }
    },
  },
}
</script>
