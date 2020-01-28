<template>
  <main class="MainContent" :class="pageMod">
    <div class="MainContent_heading">
      <button class="BackButton u-mr20" v-if="isDetail" @click="$router.go(-1)">←</button>
      <h1 class="MainContent_title" v-if="isOnly('MainContentTitle')">{{ title }}</h1>
    </div>
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
      isDetail(){
        const path = this.$route.path
        return !!path.match(/^\/(works|customers)\/[1-9]?[0-9]+$/g)
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
  }
</script>
