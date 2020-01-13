<template>
  <div class="p-works">
    <div class="MainLayout --hasWorks">
      <h1 class="MainLayout_heading"></h1>
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div v-if="!hasData">現在募集中の案件はありません</div>
          <div v-else>
            <Pager
              v-if="lastPage > 1"
              :current-page="currentPage"
              :last-page="lastPage"
              path="works"
            ></Pager>
            <WorkListLayout :works="works"></WorkListLayout>
          </div>
        </section>
      </div>
    </div>
    <RouterLink to="/works/create" tag="button" class="Button --pink --fixed"
      >募集を投稿する</RouterLink
    >
  </div>
</template>
<script>
import WorkListLayout from '@/layouts/WorkListLayout'
import Pager from '@/components/Pager'
import { OK } from '@/util'
export default {
  components: {
    WorkListLayout,
    Pager,
  },
  props: {
    page: {
      type: Number,
    },
  },
  data() {
    return {
      works: [],
      from: null,
      to: null,
      currentPage: null,
      lastPage: null,
      hasData: true,
    }
  },
  watch: {
    $route: {
      async handler() {
        await this.index()
      },
      immediate: true,
    },
  },
  methods: {
    async index() {
      this.$store.commit('form/setIsLoading', true)
      const response = await axios.get('/api/works', {
        params: {
          page: this.page,
        },
      })
      if (response.status !== OK) {
        this.$store.commit('form/setResponse', response)
        this.hasData = false
      } else {
        this.works = response.data.data
        this.from = response.data.from
        this.to = response.data.to
        this.currentPage = response.data.current_page
        this.lastPage = response.data.last_page
        this.hasData = true
      }
      this.$store.commit('form/setIsLoading', false)
    },
  },
}
</script>
