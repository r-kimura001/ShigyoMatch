<template>
  <div class="MainLayout">
    <div class="MainLayout_boxList">
      <section class="MainLayout_box">
        <p>Show</p>
      </section>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    work: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
}
</script>
