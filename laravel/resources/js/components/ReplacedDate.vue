<template>
  <div class="ReplacedDate">
    <span>{{ action }}日時:</span>
    <span>{{ replacedDate }}</span>
  </div>
</template>
<script>
  import { dateReplace } from '@/util'
  export default {
    props: {
      datetime: {
        type: String,
        default: '2020-01-08 12:30'
      },
      action: {
        type: String,
        default: '登録'
      }
    },
    computed: {
      replacedDate(){
        return dateReplace(this.datetime)
      }
    }
  }
</script>
