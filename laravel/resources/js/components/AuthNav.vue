<template>
  <div class="AuthNav" :class="{ '--open': isOpen }">
    <button
      class="AuthNav_toggle"
      :style="bgImage(authImageSrc)"
      @click="toggleMenu"
    ></button>
    <ul class="AuthNav_menu">
      <li class="AuthNav_item --title">
        <h3 class="AuthNav_menuTitle">{{ customer.name }}様</h3>
      </li>
      <RouterLink :to="`/mypage/${customer.id}`" tag="li" class="AuthNav_item"
        >マイページ</RouterLink
      >
      <RouterLink
        :to="`/mypage/${customer.id}/profile`"
        tag="li"
        class="AuthNav_item"
        :style="bgImage('assets/icon-profile-white.svg')"
      >プロフィール</RouterLink
      >
      <RouterLink
        :to="`/mypage/${customer.id}/scouts`"
        tag="li"
        class="AuthNav_item"
        :style="bgImage('assets/icon-scout-white.svg')"
        >スカウト</RouterLink
      >
      <RouterLink
        :to="`/mypage/${customer.id}/messages`"
        tag="li"
        class="AuthNav_item"
        :class="{'--hasNote': customer.message_notes.length}"
        :style="bgImage('assets/icon-mail-white.svg')"
        >メッセージ</RouterLink
      >
      <li
        class="AuthNav_item"
        @click="clickLogout"
        :style="bgImage('assets/icon-logout-white.svg')"
      >ログアウト</li>
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
    // ルートが変更されたらfetchDataメソッドを再び呼び出す
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
