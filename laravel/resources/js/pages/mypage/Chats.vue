<template>
  <div class="p-chats u-pa20">
    <section class="MypageContent_box">Chats</section>
  </div>
</template>
<script>
export default {
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
}
</script>
