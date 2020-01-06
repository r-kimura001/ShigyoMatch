<template>
  <header class="Header">
    <div class="Header_nav">
      <div class="ContentBox u-px20">
        <div class="HorizontalLayout --vertical">
          <RouterLink to="/" tag="h1" class="HorizontalLayout_col"
            >士業のマッチングサイトです</RouterLink
          >
          <GlobalNav class="HorizontalLayout_col --flex"></GlobalNav>
          <div class="HorizontalLayout_col">
            <RouterLink
              v-if="!isLogin()"
              tag="button"
              to="/login"
              class="Button --small --green --hasShadow"
              >ログイン</RouterLink
            >
            <RouterLink
              to="/signup"
              tag="button"
              class="Button --small --pink --hasShadow"
              >新規登録</RouterLink
            >
            <button v-if="isLogin()" class="Button --small" @click="logout">
              ログアウト
            </button>
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
import MainVisual from '@/components/MainVisual'
import switchDisplay from '@/mixins/switchDisplay'
import { mapGetters } from 'vuex'
export default {
  components: {
    GlobalNav,
    MainVisual,
  },
  mixins: [switchDisplay],
  computed: {
    ...mapGetters({
      authCheck: 'auth/isLogin',
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
