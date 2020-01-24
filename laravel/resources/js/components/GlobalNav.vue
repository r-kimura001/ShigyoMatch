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
        exact-active-class="--current"
        class="GlobalNav_item"
      >
        制作者紹介
      </RouterLink>
      <li
        v-for="(item, index) in navs"
        :key="index"
        class="GlobalNav_item"
        @mouseenter="showChildren(index)"
        @mouseleave="showChildren(null)"
      >
        <span>{{ item.name }}</span>
        <span class="GlobalNav_childrenToggle" @click="toggleChildren(index)" :class="{'--open': currentChildren === index}"></span>
        <ul class="GlobalNav_children" :class="{'--show': currentChildren === index}">
          <RouterLink
            v-for="(child, idx) in item.children"
            :key="idx"
            :to="{ path: item.path, query: { skill: child.name}}"
            tag="li"
            class="GlobalNav_childrenItem"
            exact-active-class="--current"
            :style="fontColor(child.id)">{{ child.name }}</RouterLink>
        </ul>
      </li>
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
import styles from '@/mixins/styles'
import { CLIENT_WIDTH } from '@/util'
import { mapGetters } from 'vuex'
export default {
  mixins: [ styles ],
  data() {
    return {
      isOpen: false,
      navs: [
        {
          path: '/works',
          name: '案件を探す',
          children: [
            {
              id: 1,
              name: '弁護士'
            },
            {
              id: 2,
              name: '司法書士'
            },
            {
              id: 3,
              name: '行政書士'
            },
            {
              id: 4,
              name: '税理士'
            },
          ]
        },
        {
          path: '/customers',
          name: '人材を探す',
          children: [
            {
              id: 1,
              name: '弁護士'
            },
            {
              id: 2,
              name: '司法書士'
            },
            {
              id: 3,
              name: '行政書士'
            },
            {
              id: 4,
              name: '税理士'
            },
          ]
        },
      ],
      currentChildren: null,
      o_middleDevice: false
    }
  },
  watch: {
    // ルートが変更されたらfetchDataメソッドを再び呼び出す
    $route: {
      async handler(){
        await this.fetchData()
        this.o_middleDevice = CLIENT_WIDTH > 768
      }
    },
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
      this.currentChildren = null
    },
    isLogin() {
      return this.authCheck
    },
    showChildren(index){
      if(this.o_middleDevice){
        this.currentChildren = index
      }
    },
    toggleChildren(index){
      this.currentChildren = this.currentChildren === index ? null : index
    },
    fontColor(id){
      return {
        color: this.colorById(id)
      }
    },
  },
}
</script>
