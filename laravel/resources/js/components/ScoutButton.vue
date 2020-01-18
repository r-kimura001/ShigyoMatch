<template>
  <div>
    <button class="Button --minimum" @click="$router.push(`/customers/${id}/scout`)">
      スカウト
    </button>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: Number,
      required: true,
    }
  },
}
</script>
