<template>
  <div class="p-favorites">
    <h2>Favorites</h2>
    <section class="MypageContent_box">
      <h3>気になる</h3>
      <section class="MypageContent_box">
        <h3 class="">気になる案件</h3>
        <p v-if="!hasData">気になるした案件はありません</p>
        <WorkListLayout
          v-else
          :works="works"
          @sendDelete="openDeleteModal"
        ></WorkListLayout>
      </section>
    </section>
  </div>
</template>
<script>
  import { OK } from '@/util'
  import WorkListLayout from '@/layouts/WorkListLayout'
export default {
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
        this.$store.commit('form/setIsLoading', true)
        await this.favoriteWorks()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  components: { WorkListLayout },
  methods: {
    async favoriteWorks() {
      const response = await axios.get(
        `/api/customers/${this.customer.id}/favoriteWorks`
      )
      this.$store.commit('form/setResponse', response)
      if (response.status !== OK) {
        this.hasData = false
      } else {
        this.works = response.data
        this.hasData = !!this.works.length
      }
    },
  }
}
</script>
