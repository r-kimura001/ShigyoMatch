<template>
  <div class="MypageContent">
    <div class="MypageContent_sidebar">
      <Sidebar :id="id"></Sidebar>
    </div>
    <div class="MypageContent_main">
      <h1>{{ customer.name }}様</h1>
      <RouterView
        :customer="customer"
        @readed="setEmpty"
      ></RouterView>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import Sidebar from '@/components/mypage/Sidebar.vue'
export default {
  components: { Sidebar },
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapState({
      customer: state => state.auth.customer,
    }),
    self() {
      return !this.customer ? false : this.customer.id == this.id
    },
  },
  watch: {
    self: {
      async handler(val) {
        if (!val) {
          this.$router.push(`/mypage/${this.customer.id}`)
        }
      },
      immediate: true,
    },
  },
  methods: {
    setEmpty(data){
      this.$store.commit('auth/setEmpty', data)
    }
  }
}
</script>
