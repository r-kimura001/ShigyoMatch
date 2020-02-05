<template>
  <main class="p-top">
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <Introductions></Introductions>
        </section>
      </div>
    </div>
    <div class="PageMask">
      <div class="PageMask_mark">
        <div class="PageMask_line"></div>
      </div>
    </div>
  </main>
</template>
<script>
import Introductions from '@/layouts/Introductions'
import switchDisplay from '@/mixins/switchDisplay'
export default {
  mixins: [switchDisplay],
  components: { Introductions },
  data(){
    return {
      isVisible: false
    }
  },
}
</script>
