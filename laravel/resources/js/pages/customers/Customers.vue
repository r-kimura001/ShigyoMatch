<template>
  <div class="p-works">
    <div class="MainLayout --customers">
      <h1 class="MainLayout_heading">
        人材を探す
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
                <h2>{{ skill }}事務所一覧</h2>
                <!-- Pager -->
                <Pager
                  v-if="lastPage > 1"
                  :current-page="currentPage"
                  :last-page="lastPage"
                  path="customers"
                  :professionType="skill"
                ></Pager>
              </div>
              <CustomerListLayout :customers="list"></CustomerListLayout>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import CustomerListLayout from '@/layouts/CustomerListLayout'
import apiIndexHandler from '@/mixins/apiIndexHandler'

export default {
  components: { CustomerListLayout },
  mixins: [apiIndexHandler],
}
</script>
