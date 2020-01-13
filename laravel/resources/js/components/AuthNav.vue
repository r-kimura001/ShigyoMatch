<template>
  <div class="AuthNav" :class="{ '--open': isOpen }">
    <button
      class="AuthNav_toggle"
      :style="bgImage(authImageSrc)"
      @click="toggleMenu"
    ></button>
    <ul class="AuthNav_menu">
      <li class="AuthNav_item">{{ customer.name }}様</li>
      <RouterLink :to="`/mypage/${customer.id}`" tag="li" class="AuthNav_item"
        >マイページ</RouterLink
      >
      <li class="AuthNav_item" @click="clickLogout">ログアウト</li>
    </ul>
  </div>
</template>
<script>
import styles from '@/mixins/styles'
import { BASE_STORAGE_URL } from '@/util'
export default {
  mixins: [styles],
  props: {
    customer: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isOpen: false,
    }
  },
  computed: {
    authImageSrc() {
      return this.customer.file_name
        ? this.customer.file_name
        : 'assets/icon-no-user-thumb.svg'
    },
  },
  watch: {
    // ルートが変更されたらfetchDataメソッドを再び呼び出します
    $route: 'fetchData',
  },
  methods: {
    clickLogout() {
      this.$emit('clickLogout')
    },
    toggleMenu() {
      this.isOpen = !this.isOpen
    },
    fetchData() {
      this.isOpen = false
    },
  },
}
</script>
