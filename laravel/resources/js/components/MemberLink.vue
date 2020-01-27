<template>
  <RouterLink
    :to="`/customers/${customer.id}`"
    tag="div"
    class="MemberLink"
  >
    <span class="MemberLink_thumb" :style="bgImage(customer.file_name)"></span>
    <span class="MemberLink_text" :data-unit="unit">{{ customer.name }}</span>
  </RouterLink>
</template>
<script>
  import styles from '@/mixins/styles'
  export default {
    props: {
      customer: {
        type: Object,
        default: () => ({})
      },
      unit: {
        type: String,
        default: ''
      }
    },
    mixins: [styles]
  }
</script>
