<template>
  <div class="MypageContent">
    <div class="MypageContent_sidebar">
      <Sidebar :id="id"></Sidebar>
    </div>
    <div class="MypageContent_main">
      <RouterView></RouterView>
    </div>
  </div>
</template>
<script>
import Sidebar from '@/components/mypage/Sidebar.vue'
export default {
  components: { Sidebar },
  props: {
    id: {
      type: String,
      required: true,
    },
  },
}
</script>
