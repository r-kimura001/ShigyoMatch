<template>
  <div class="p-messages">
    <section class="MainLayout_box">Messages</section>
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
