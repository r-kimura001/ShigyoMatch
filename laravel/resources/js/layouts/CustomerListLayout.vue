<template>
  <div class="CustomerListLayout">
    <ul class="CustomerList_list">
      <li
        v-for="customer in customers"
        :key="customer.key"
        class="CustomerList_item"
      >
        <Card :customer="customer"></Card>
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
    hasData: {
      type: Boolean,
      default: true
    }
  },
}
</script>
