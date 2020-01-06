<template>
  <header class="Header">
    <div class="Header_nav">
      <div class="ContentBox">
        <RouterLink to="/" tag="h1" class="SiteTitle"
          >士業のマッチングサイトです</RouterLink
        >
        <GlobalNav></GlobalNav>
        <div>
          <RouterLink to="/signup" tag="button" class="Button"
            >新規登録</RouterLink
          >
          <RouterLink v-if="!isLogin()" tag="button" to="/login"
            >ログイン</RouterLink
          >
          <button v-if="isLogin()" class="Button" @click="logout">
            ログアウト
          </button>
        </div>
      </div>
      <!-- ContentBox -->
    </div>
    <!-- Header_nav -->
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
