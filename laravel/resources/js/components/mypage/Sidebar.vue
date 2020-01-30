<template>
  <aside class="Sidebar" :class="{'--hidden': ignore}">
    <div class="Sidebar_list">
      <div
        v-for="(list, index) in menuList"
        :key="index"
        class="Sidebar_listItem"
      >
        <RouterLink
          :to="`/mypage/${id}${list.path}`"
          tag="div"
          class="Sidebar_listBody"
          exact-active-class="--current"
          ><div
            class="Sidebar_listLabel"
            :style="bgImage(`assets/${list.iconSrc}`)"
          >
            <span class="Sidebar_listText">{{ list.name }}</span>
          </div>
        </RouterLink>
      </div>
    </div>
  </aside>
</template>
<script>
import styles from '@/mixins/styles'
import { CLIENT_WIDTH } from '@/util'
export default {
  mixins: [styles],
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  watch: {

    $route: {
      handler(){
        this.o_middleDevice = CLIENT_WIDTH > 768
      },
      immediate: true
    },
  },
  data() {
    return {
      menuList: [
        {
          name: 'HOME',
          path: '',
          iconSrc: 'icon-home.svg',
        },
        {
          name: 'マッチング履歴',
          path: '/matches',
          iconSrc: 'icon-match.svg',
        },
        {
          name: '申込',
          path: '/applies',
          iconSrc: 'icon-postBox.svg',
        },
        {
          name: '気になる',
          path: '/favorites',
          iconSrc: 'icon-favorite.svg',
        },
      ],
      o_middleDevice: false
    }
  },
  computed: {
    ignore(){
      const currentPath = this.$route.path
      return !this.o_middleDevice && currentPath.indexOf('messages') != -1
    }
  }
}
</script>
