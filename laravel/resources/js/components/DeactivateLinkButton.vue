<template>
  <span class="DeactivateLinkButton" @click="$router.push(`/mypage/${customerId}/deactivate`)">退会はこちら</span>
</template>
<script>
  export default {
    props: {
      customerId: {
        type: Number,
        required: true
      }
    }
  }
</script>
