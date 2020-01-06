<template>
  <div class="PageContent">
    <div class="PageContent_layout">
      <Header v-if="!ignore('Header')"></Header>
    </div>
    <div class="PageContent_layout --flex">
      <MainContent></MainContent>
    </div>
    <div class="PageContent_layout">
      <Footer v-if="!ignore('Footer')"></Footer>
    </div>
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
