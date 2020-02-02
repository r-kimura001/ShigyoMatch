<template>
  <div
    v-if="noLink"
    class="MemberLink --noLink"
  >
    <span class="MemberLink_thumb" :style="bgImage(customer.file_name)"></span>
    <span class="MemberLink_text" :class="{'--white': white}" :data-unit="unit">{{ customer.name }}</span>
  </div>
  <RouterLink
    v-else
    :to="`/customers/${customer.id}`"
    tag="div"
    class="MemberLink"
  >
    <span class="MemberLink_thumb" :style="bgImage(customer.file_name)"></span>
    <span class="MemberLink_text" :class="{'--white': white}" :data-unit="unit">{{ customer.name }}</span>
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
      },
      noLink: {
        type: Boolean,
        default: false
      },
      white: {
        type: Boolean,
        default: false
      }
    },
    mixins: [styles]
  }
</script>
