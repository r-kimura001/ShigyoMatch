<template>
  <div class="MypageContent">
    <div class="MypageContent_sidebar">
      <Sidebar :id="id"></Sidebar>
    </div>
    <div class="MypageContent_main">
      <RouterView :id="id"></RouterView>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import Sidebar from '@/components/mypage/Sidebar.vue'
export default {
  components: { Sidebar },
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  computed: {
    ...mapGetters({
      customerId: 'auth/customerId',
    }),
    self() {
      return this.customerId == this.id
    },
  },
  watch: {
    self: {
      async handler(val) {
        if (!val) {
          this.$router.push(`/mypage/${this.customerId}`)
        }
      },
      immediate: true,
    },
  },
}
</script>
