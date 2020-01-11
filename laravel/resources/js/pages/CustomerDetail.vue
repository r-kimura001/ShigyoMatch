<template>
  <div class="p-customer-details">
    <div class="MainLayout --customerDetail">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <CustomerInfoLayout :customer="customer"></CustomerInfoLayout>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import { OK } from '@/util'
import CustomerInfoLayout from '@/layouts/CustomerInfoLayout'
export default {
  components: {
    CustomerInfoLayout,
  },
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      customer: null,
    }
  },
  computed: {
    matches() {
      return this.customer.matches
    },
    followers() {
      return this.customer.followers
    },
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.show()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async show() {
      const response = await axios.get(`/api/customers/${this.id}`)
      if (response.status === OK) {
        this.customer = response.data
      } else {
        this.$store.commit('form/setResponse', response)
      }
    },
  },
}
</script>
