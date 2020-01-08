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
    </ul>
  </nav>
</template>
<script>
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
          name: '案件検索',
        },
        {
          path: '/customers',
          name: '事務所検索',
        },
      ],
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
