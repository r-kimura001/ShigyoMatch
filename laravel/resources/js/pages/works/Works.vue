<template>
  <div class="p-works">
    <div class="MainLayout --hasWorks">
      <h1 class="MainLayout_heading">募集案件一覧</h1>
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div v-if="!hasData">現在募集中の案件はありません</div>
          <div v-else>
            <Pager
              v-if="lastPage > 1"
              :current-page="currentPage"
              :last-page="lastPage"
              path="works"
              :professionType="skill"
            ></Pager>
            <WorkListLayout :works="list"></WorkListLayout>
          </div>
        </section>
      </div>
    </div>
    <button
      v-if="author"
      class="Button --pink --fixed"
      @click="toCreate()"
      >案件を募集する</button
    >
  </div>
</template>
<script>
import WorkListLayout from '@/layouts/WorkListLayout'
import apiIndexHandler from '@/mixins/apiIndexHandler'
import { mapState } from 'vuex'
export default {
  components: { WorkListLayout },
  mixins: [apiIndexHandler],
  computed: {
    ...mapState({
      author: state => state.auth.customer
    })
  },
  methods: {
    toCreate(){
      if(!this.author){
        alert('募集案件を投稿するにはログインしてください')
        return false
      }else{
        this.$router.push('/works/create')
      }
    }
  }
}
</script>
