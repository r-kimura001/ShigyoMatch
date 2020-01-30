<template>
  <div class="PageContent" :class="pageMod">
    <div class="PageContent_layout">
      <Header v-if="!ignore('Header')"></Header>
    </div>
    <div class="PageContent_layout --flex">
      <MainContent></MainContent>
    </div>
    <div class="PageContent_layout">
      <Footer v-if="!ignore('Footer')"></Footer>
    </div>
    <div class="Button --fixed --orange" @click="preLogin" v-if="!isLogin">簡単ログインで体験する</div>
  </div>
</template>
<script>
import switchDisplay from '@/mixins/switchDisplay'
import Header from '@/components/Header'
import Footer from '@/components/Footer'
import MainContent from '@/components/MainContent'
import { mapGetters } from 'vuex'
export default {
  components: {
    Header,
    MainContent,
    Footer,
  },
  data(){
    return {
      test: null,
    }
  },
  mixins: [switchDisplay],
  computed: {
    ...mapGetters({
      isLogin: 'auth/isLogin',
      apiStatus: 'auth/apiStatus',
      customerId: 'auth/customerId'
    }),
    pageMod(){
      const path = this.$route.path
      this.test = path
      if(path.indexOf('/customers') != -1) {
        return {
          '--customers': true
        }
      } else if(path.indexOf('/mypage') != -1) {
        return {
          '--mypage': true
        }
      }
    }
  },
  methods: {
    async preLogin(){
      this.$store.commit('form/setIsLoading', true)
      const formData = new FormData()
      formData.append('login_id', 'testuser')
      formData.append('password', 'test1234')
      await this.$store.dispatch('auth/login', formData)

      this.$store.commit('form/setIsLoading', false)

      if (this.apiStatus) {
        this.$router.push(`/mypage/${this.customerId}`)
      }
    },
  }
}
</script>
