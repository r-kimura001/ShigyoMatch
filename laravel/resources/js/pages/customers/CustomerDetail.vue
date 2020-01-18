<template>
  <div class="p-customer-details">
    <RouterView :customer="item" :paramPath="paramPathOfWork"></RouterView>
  </div>
</template>
<script>
import apiShowHandler from '@/mixins/apiShowHandler'
export default {
  props: {
    paramPathOfWork: {
      type: String
    }
  },
  mixins: [apiShowHandler],
}
</script>
