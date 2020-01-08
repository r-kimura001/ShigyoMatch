<template>
  <div>
    <small
      v-for="(message, index) in errorMessage"
      :key="index"
      class="ValidationErrorMessage"
      >{{ message }}</small
    >
  </div>
</template>
<script>
export default {
  props: {
    errorMessage: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
}
</script>
