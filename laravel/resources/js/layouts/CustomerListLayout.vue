<template>
  <div class="CustomerListLayout">
    <ul class="CustomerList_list">
      <li
        v-for="customer in customers"
        :key="customer.key"
        class="CustomerList_item"
      >
        <Card :item="customer"></Card>
      </li>
    </ul>
  </div>
</template>
<script>
import Card from '@/components/Card'
export default {
  components: {
    Card,
  },
  props: {
    customers: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
}
</script>
