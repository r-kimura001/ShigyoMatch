<template>
  <div>
    <CustomerPage v-if="!isAdmin" />
    <AdminPage v-else />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR, UNAUTHORIZED, NOT_FOUND } from '@/util'
import { mapGetters } from 'vuex'
import CustomerPage from '@/pages/CustomerPage'
import AdminPage from '@/admin/AdminPage'
export default {
  components: { CustomerPage, AdminPage },
  computed: {
    ...mapGetters({
      errorCode: 'error/getStatus',
      isAdmin: 'auth/isAdmin',
    }),
  },
  watch: {
    errorCode: {
      async handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        } else if (val === UNAUTHORIZED) {
          // トークンをリフレッシュ
          await axios.get('/api/refresh-token')
          // ストアのuserをクリア
          this.$store.commit('auth/setCustomer', null)
          // ログイン画面へ
          this.$router.push('/login')
        } else if (val === NOT_FOUND) {
          this.$router.push('/not-found')
        }
      },
      immediate: true,
    },
    $route() {
      this.$store.commit('error/setStatus', null)
    },
  },
}
</script>
