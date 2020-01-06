<template>
  <div>
    <RouterView></RouterView>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
  },
}
</script>
