<template>
  <div class="Loader">
    <div class="Loader_overlay"></div>
    <div class="Loader_content">
      <vue-loading
        type="spiningDubbles"
        color="#fefefe"
        :size="{ width: '100px', height: '100px' }"
      ></vue-loading>
    </div>
  </div>
</template>
<script>
import { VueLoading } from 'vue-loading-template'
export default {
  components: {
    VueLoading,
  },
}
</script>
