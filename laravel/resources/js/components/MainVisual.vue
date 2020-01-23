<template>
  <div class="MainVisual">
    <div class="MainVisual_cover"></div>
    <div
      class="MainVisual_panel"
      v-for="(panel, index) in panels"
      :key="index"
      :data-id="index"
      :style="panelStyle(panel, index)"></div>
    <h1 class="MainVisual_phrase">
      <span class="u-pa20">プロフェッショナルを<br>シェアする</span>
    </h1>
  </div>
</template>
<script>
import styles from '@/mixins/styles'
import { BASE_STORAGE_URL } from '@/util'
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
  methods: {
    panelStyle(panel, index){
      const delay = index * this.panels.length
      return {
        backgroundImage: `url(${BASE_STORAGE_URL}/${panel.src})`,
        animationDelay: `${delay}s`
      }
    }
  }
}
</script>
