<template>
  <footer class="Footer">
    <div class="Footer_content">
      <p class="Footer_text">
        &copy; Kaba {{ createdYear }}{{ currentYear() }} All Rights Reserved.
      </p>
    </div>
  </footer>
</template>

<script>
import { CLIENT_HEIGHT } from '@/util'
export default {
  data() {
    return {
      createdYear: 2019,
      test: null,
    }
  },
  mounted() {
    this.moveDuePosition()
  },
  methods: {
    currentYear() {
      const now = new Date().getFullYear()
      return this.createdYear < now ? `-${now}` : ''
    },
    moveDuePosition() {
      const deviceHeight = CLIENT_HEIGHT
      const footerEl = this.$el.querySelector('.Footer')
      const footerHeight = footerEl.clientHeight
      const limitPosition = deviceHeight - footerHeight
      const footerPosition = footerEl.getBoundingClientRect().top

      this.test = {
        device_height: deviceHeight,
        footer_height: footerHeight,
        footer_position: footerPosition,
        limit_position: limitPosition,
      }
    },
  },
}
</script>
