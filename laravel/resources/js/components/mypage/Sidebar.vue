<template>
  <div class="Sidebar">
    <div v-for="(list, index) in lists" :key="index">
      <RouterLink
        :to="`/mypage/${id}/${list.path}/`"
        tag="div"
        class="Sidebar_listItem"
        :style="bgImage('assets', list.iconSrc)"
        >{{ list.name }}</RouterLink
      >
    </div>
    <div>ログアウト</div>
  </div>
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
          path: 'profiles',
          iconSrc: 'icon-profile.svg',
        },
        {
          name: 'マッチング履歴',
          path: 'matches',
          iconSrc: 'icon-match.svg',
        },
        {
          name: 'スカウト',
          path: 'scouts',
          iconSrc: '',
        },
        {
          name: '申込',
          path: 'applies',
          iconSrc: '',
        },
        {
          name: '気になる',
          path: 'favorites',
          iconSrc: 'icon-favorite.svg',
        },
        {
          name: 'メッセージ',
          path: 'messages',
          iconSrc: 'icon-mail-line.svg',
        },
        {
          name: 'チャットルーム',
          path: 'chats',
          iconSrc: 'icon-chat.svg',
        },
      ],
    }
  },
}
</script>
