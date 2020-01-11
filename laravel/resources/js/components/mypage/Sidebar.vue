<template>
  <aside class="Sidebar">
    <div class="Sidebar_list">
      <div v-for="(list, index) in lists" :key="index" class="Sidebar_listItem">
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
export default {
  mixins: [styles],
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      lists: [
        {
          name: 'HOME',
          path: '',
          iconSrc: 'icon-home.svg',
        },
        {
          name: 'プロフィール',
          path: '/profile',
          iconSrc: 'icon-profile.svg',
        },
        {
          name: 'マッチング履歴',
          path: '/matches',
          iconSrc: 'icon-match.svg',
        },
        {
          name: 'スカウト',
          path: '/scouts',
          iconSrc: 'icon-scout.svg',
        },
        {
          name: '申込',
          path: '/applies',
          iconSrc: '',
        },
        {
          name: '気になる',
          path: '/favorites',
          iconSrc: 'icon-favorite.svg',
        },
        {
          name: 'メッセージ',
          path: '/messages',
          iconSrc: 'icon-mail-line.svg',
        },
        {
          name: 'チャットルーム',
          path: '/chats',
          iconSrc: 'icon-chat.svg',
        },
      ],
    }
  },
}
</script>
