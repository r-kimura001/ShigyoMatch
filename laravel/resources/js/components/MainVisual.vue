<template>
  <div class="MainVisual" :style="height">
    <div class="MainVisual_cover"></div>
    <div
      class="MainVisual_panel"
      v-for="(panel, index) in panels"
      :key="index"
      :data-id="index"
      :style="panelStyle(panel, index)"></div>
    <h1 class="MainVisual_phrase">
      <span>プロフェッショナルを<br>シェアする</span>
    </h1>
    <div class="MainVisual_scrollBtn" @click="toContent()">↓</div>
  </div>
</template>
<script>
import styles from '@/mixins/styles'
import { BASE_STORAGE_URL, CLIENT_HEIGHT } from '@/util'
export default {
  mixins: [styles],
  data(){
    return {
      panels: [
        {
          src: 'assets/main-visual01.jpg',
        },
        {
          src: 'assets/main-visual02.jpg',
        },
        {
          src: 'assets/main-visual03.jpg',
        },
        {
          src: 'assets/main-visual04.jpg',
        },
      ],
    }
  },
  computed: {
    deviceHeight(){
      return CLIENT_HEIGHT
    },
    height(){
      const headerHeight = 53
      return {
        height: `${this.deviceHeight - headerHeight}px`
      }
    }
  },
  methods: {
    panelStyle(panel, index){
      const pageMaskDurarion = 2 //variables.scssの$pageMaskDurarion - 1
      const delay = index * this.panels.length + pageMaskDurarion
      return {
        backgroundImage: `url(${BASE_STORAGE_URL}/${panel.src})`,
        animationDelay: `${delay}s`
      }
    },
    toContent(){
      this.$scrollTo('.MainContent', 1500, {
        easing: 'ease-out'
      })
    }
  }
}
</script>
