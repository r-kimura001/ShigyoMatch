<template>
  <header class="Header">
    <div class="Header_nav">
      <div class="ContentBox u-px20">
        <div class="HorizontalLayout --vertical">
          <RouterLink to="/" tag="h1" class="HorizontalLayout_col"
            >士業のマッチングサイトです</RouterLink
          >
          <GlobalNav class="HorizontalLayout_col --flex"></GlobalNav>
          <div v-if="isLogin" class="HorizontalLayout_col">
            <AuthNav :customer="customer" @clickLogout="logout"></AuthNav>
          </div>
          <div class="HorizontalLayout_col">
            <RouterLink
              v-if="!isLogin()"
              to="/login"
              tag="button"
              class="Button --small --green --hasShadow"
              >ログイン</RouterLink
            >
            <RouterLink
              v-if="!isLogin()"
              to="/signup"
              tag="button"
              class="Button --small --pink --hasShadow"
              >新規登録</RouterLink
            >
          </div>
        </div>
        <!-- HorizontalLayout -->
      </div>
      <!-- ContentBox -->
    </div>
    <!-- Header_nav -->
    <div class="Header_fix"></div>
    <MainVisual v-if="isOnly('MainVisual')"></MainVisual>
  </header>
</template>
<script>
import GlobalNav from '@/components/GlobalNav'
import AuthNav from '@/components/AuthNav'
import MainVisual from '@/components/MainVisual'
import switchDisplay from '@/mixins/switchDisplay'
import { mapGetters, mapState } from 'vuex'
export default {
  components: {
    GlobalNav,
    MainVisual,
    AuthNav,
  },
  mixins: [switchDisplay],
  computed: {
    ...mapState({
      customer: state => state.auth.customer,
    }),
    ...mapGetters({
      authCheck: 'auth/isLogin',
      customerId: 'auth/customerId',
    }),
  },
  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout')

      if (this.apiStatus) {
        this.$router.push('/login')
      }
    },

    isLogin() {
      return this.authCheck
    },
  },
}
</script>
