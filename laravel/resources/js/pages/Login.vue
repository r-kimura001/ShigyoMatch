<template>
  <div class="p-login" :style="bgImage()">
    <Loader :class="{ '--show': isLoading }" />
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div class="LoginFormLayout">
            <div class="Form --auth">
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
                    class="Form_text"
                    placeholder="ログインID"
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
                    placeholder="パスワード"
                    required
                  />
                </div>
                <div class="Form_row u-alignCenter">
                  <button class="Form_button Button --hasShadow">
                    ログイン
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
import { BASE_ASSET_URL } from '@/util'
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

    bgImage() {
      return {
        backgroundImage: `url(${BASE_ASSET_URL}/bg-login.jpg)`,
      }
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
