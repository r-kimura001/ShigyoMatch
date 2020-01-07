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
        to="/greeting"
        tag="li"
        class="GlobalNav_item"
        exact-active-class="--current"
        @click="hideMenu()"
        >制作者紹介</RouterLink
      >
      <RouterLink
        to="/works"
        tag="li"
        class="GlobalNav_item"
        a
        exact-active-class="--current"
        @click="hideMenu()"
        >案件検索</RouterLink
      >
      <RouterLink
        to="/customers"
        tag="li"
        class="GlobalNav_item"
        exact-active-class="--current"
        @click="hideMenu()"
        >事務所検索</RouterLink
      >
    </ul>
  </nav>
</template>
<script>
export default {
  data() {
    return {
      isOpen: false,
    }
  },
  watch: {
    // ルートが変更されたらfetchDataメソッドを再び呼び出します
    $route: 'fetchData',
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
  },
}
</script>
