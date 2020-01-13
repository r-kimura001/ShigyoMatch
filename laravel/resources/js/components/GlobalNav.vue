<template>
  <nav class="GlobalNav">
    <button
      class="GlobalNav_toggle"
      :class="{ '--open': isOpen }"
      @click="toggleMenu()"
    >
      <span class="Globalnav_toggleLine --first"></span>
      <span class="Globalnav_toggleLine --second"></span>
      <span class="Globalnav_toggleLine --third"></span>
    </button>
    <ul class="GlobalNav_menu" :class="{ '--open': isOpen }">
      <RouterLink
        v-for="(item, index) in navs"
        :key="index"
        :to="`${item.path}`"
        tag="li"
        class="GlobalNav_item"
        exact-active-class="--current"
        >{{ item.name }}</RouterLink
      >
      <RouterLink
        v-if="!isLogin()"
        to="/login"
        tag="li"
        class="GlobalNav_item --u-md"
        exact-active-class="--current"
        >ログイン</RouterLink
      >
      <RouterLink
        v-if="!isLogin()"
        to="/signup"
        tag="li"
        class="GlobalNav_item --u-md"
        exact-active-class="--current"
        >新規登録</RouterLink
      >
    </ul>
  </nav>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  data() {
    return {
      isOpen: false,
      navs: [
        {
          path: '/greeting',
          name: '制作者紹介',
        },
        {
          path: '/works',
          name: '案件を探す',
        },
        {
          path: '/customers',
          name: '人材を探す',
        },
      ],
    }
  },
  watch: {
    // ルートが変更されたらfetchDataメソッドを再び呼び出します
    $route: 'fetchData',
  },
  computed: {
    ...mapGetters({
      authCheck: 'auth/isLogin',
    }),
  },
  methods: {
    toggleMenu() {
      this.isOpen = !this.isOpen
    },
    hideMenu() {
      this.isOpen = false
    },
    fetchData() {
      this.isOpen = false
    },
    isLogin() {
      return this.authCheck
    },
  },
}
</script>
