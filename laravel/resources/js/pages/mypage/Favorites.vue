<template>
  <div class="p-favorites">
    <section class="MainLayout_box">Favorites</section>
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
