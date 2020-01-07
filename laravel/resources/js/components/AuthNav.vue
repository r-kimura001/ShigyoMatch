<template>
  <div class="AuthNav" :class="{ '--open': isOpen }">
    <button class="AuthNav_toggle" @click="toggleMenu">
      <img src="" alt="" class="AuthNav_toggleSrc" />
    </button>
    <ul class="AuthNav_menu">
      <RouterLink :to="`/mypage/${customer.id}`" tag="li" class="AuthNav_item"
        >マイページ</RouterLink
      >
      <li class="AuthNav_item" @click="clickLogout">ログアウト</li>
    </ul>
  </div>
</template>
<script>
export default {
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
  methods: {
    clickLogout() {
      this.$emit('clickLogout')
    },
    toggleMenu() {
      this.isOpen = !this.isOpen
    },
  },
}
</script>
