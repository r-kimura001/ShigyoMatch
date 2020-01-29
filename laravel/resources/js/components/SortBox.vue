<template>
  <div class="SortBox">
    <select @change="$emit('sortChange')" v-model="sortKey">
      <option v-for="item in sortList" :value="item.value">{{ item.label }}</option>
    </select>
  </div>
</template>
<script>
  export default {
    props: {
      sortList: {
        type: Array,
        default: () => ([])
      },
      sortKey: {

      }
    },
  }
</script>
