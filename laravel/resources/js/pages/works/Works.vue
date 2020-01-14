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
            <WorkListLayout :works="list"></WorkListLayout>
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
import apiIndexHandler from '@/mixins/apiIndexHandler'
export default {
  components: { WorkListLayout },
  mixins: [apiIndexHandler],
}
</script>
