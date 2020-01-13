<template>
  <div class="p-works">
    <div class="MainLayout --customers">
      <h1 class="MainLayout_heading">
        事務所一覧
      </h1>
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div v-if="!hasData">登録された事務所はありません</div>
          <div v-else>
            <div class="">
              <!-- menubar -->
            </div>
            <div>
              <div>
                <!-- header_title(「弁護士一覧」みたいな) -->
                <div></div>
                <!-- Pager -->
                <Pager
                  v-if="lastPage > 1"
                  :current-page="currentPage"
                  :last-page="lastPage"
                  path="customers"
                ></Pager>
              </div>
              <CustomerListLayout :customers="customers"></CustomerListLayout>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import Pager from '@/components/Pager'
import CustomerListLayout from '@/layouts/CustomerListLayout'
import { OK } from '@/util'
export default {
  components: {
    Pager,
    CustomerListLayout,
  },
  props: {
    page: {
      type: Number,
    },
  },
  data() {
    return {
      customers: [],
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
      const response = await axios.get(`/api/customers`, {
        params: {
          page: this.page,
        },
      })
      if (response.status === OK) {
        this.customers = response.data.data
        this.hasData = this.customers.length
        this.from = response.data.from
        this.to = response.data.to
        this.currentPage = response.data.current_page
        this.lastPage = response.data.last_page
      }
      this.$store.commit('form/setIsLoading', false)
    },
  },
}
</script>
