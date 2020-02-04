<template>
  <div class="ResultLabel">
    <div class="ResultLabel_bg"></div>
    <p class="ResultLabel_text">
      <span class="ResultLabel_num">{{ total }}</span>件中<span class="ResultLabel_num">{{ from }}</span>〜<span class="ResultLabel_num">{{ to }}</span>件を表示
    </p>
  </div>
</template>
<script>
  export default {
    props: ['total', 'from', 'to']
  }
</script>
