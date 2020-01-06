<template>
  <div>
    <Header v-if="!ignore('Header')"></Header>
    <MainContent></MainContent>
    <Footer v-if="!ignore('Footer')"></Footer>
  </div>
</template>
<script>
import switchDisplay from '@/mixins/switchDisplay'
import Header from '@/components/Header'
import Footer from '@/components/Footer'
import MainContent from '@/components/MainContent'
export default {
  components: {
    Header,
    MainContent,
    Footer,
  },
  mixins: [switchDisplay],
}
</script>
