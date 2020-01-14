<template>
  <div class="p-work-details">
    <RouterView :work="item" @fetchItem="fetchItem"></RouterView>
  </div>
</template>
<script>
import { OK } from '@/util'
import apiShowHandler from '@/mixins/apiShowHandler'
export default {
  mixins: [apiShowHandler],
}
</script>
