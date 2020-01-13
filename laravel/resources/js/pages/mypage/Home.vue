<template>
  <div class="p-home">
    <div>
      <h2>Home</h2>
      <section>
        <h3 class="">投稿中の募集案件</h3>
        <p v-if="!hasData">募集案件の投稿はありません</p>
        <WorkTableLayout v-else :works="works"></WorkTableLayout>
      </section>
    </div>
  </div>
</template>
<script>
import { OK } from '@/util'
import WorkTableLayout from '@/layouts/WorkTableLayout'
export default {
  components: { WorkTableLayout },
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  data() {
    return {
      works: [],
      hasData: true,
    }
  },
  watch: {
    $route: {
      async handler() {
        await this.worksByOwner()
      },
      immediate: true,
    },
  },
  methods: {
    async worksByOwner() {
      this.$store.commit('form/setIsLoading', true)
      const response = await axios.get(
        `/api/customers/${this.customer.id}/works`
      )
      if (response.status !== OK) {
        this.$store.commit('form/setResponse', response)
        this.hasData = false
      } else {
        this.works = response.data
        this.hasData = !!this.works.length
      }
      this.$store.commit('form/setIsLoading', false)
    },
  },
}
</script>
