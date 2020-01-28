<template>
  <main class="MainContent" :class="pageMod">
    <h1 class="MainContent_title" v-if="isOnly('MainContentTitle')">{{ title }}</h1>
    <RouterView></RouterView>
  </main>
</template>
<script>
  import switchDisplay from '@/mixins/switchDisplay'
  export default {
    mixins: [switchDisplay],
    computed: {
      title(){
        if( this.$route.matched.some( obj => obj.meta.title ) ){
          return this.$route.meta.title
        } else {
          return '士業マッチングサイト'
        }
      },
      pageMod(){
        const path = this.$route.path
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

    }
  }
</script>
