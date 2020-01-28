<template>
  <div class="p-home">
    <div>
      <h2 class="MypageContent_heading">HOME</h2>
      <section class="MypageContent_box">
        <h3 class="BaseTitle">
          <span class="BaseTitle_text --report">活動レポート</span>
        </h3>
        <ul class="MypageContent_aggregate">
          <li class="MypageContent_aggregateItem">
            <div class="AggregateBox">
              <h4 class="AggregateBox_heading">マッチ件数</h4>
              <div class="AggregateBox_body">
                <span class="AggregateBox_num">{{ applies.length }}</span>
                <span class="AggregateBox_unit">件</span>
              </div>
            </div>
          </li>
          <li class="MypageContent_aggregateItem">
            <div class="AggregateBox">
              <h4 class="AggregateBox_heading">レビュー平均</h4>
              <div v-if="hasReview" class="AggregateBox_body">
                <span class="AggregateBox_num">{{ averageReview }}</span>
                <span class="AggregateBox_unit">点</span>
              </div>
              <div v-else class="AggregateBox_body">
                <span class="AggregateBox_num --nodata">
                  レビューなし
                </span>
              </div>
            </div>
          </li>
          <li class="MypageContent_aggregateItem">
            <div class="AggregateBox">
              <h4 class="AggregateBox_heading">フォロワー</h4>
              <div class="AggregateBox_body">
                <span class="AggregateBox_num">{{ customer.followers.length }}</span>
                <span class="AggregateBox_unit"></span>
              </div>
            </div>
          </li>
          <li class="MypageContent_aggregateItem">
            <div class="AggregateBox">
              <h4 class="AggregateBox_heading">フォロー</h4>
              <div class="AggregateBox_body">
                <span class="AggregateBox_num">{{ customer.followees.length }}</span>
                <span class="AggregateBox_unit"></span>
              </div>
            </div>
          </li>
        </ul>
      </section>
      <section class="MypageContent_box">
        <h3 class="BaseTitle">
          <span class="BaseTitle_text --work">投稿中の募集案件</span>
          <span class="BaseTitle_button">
            <RouterLink to="/works/create" tag="button" class="Button --small --pink">募集案件を投稿する</RouterLink>
          </span>
        </h3>
        <div class="MypageContent_body">
          <p v-if="!hasPost">募集案件の投稿はありません</p>
          <WorkTableLayout
            v-else
            :works="works"
            @sendDelete="openDeleteModal"
          ></WorkTableLayout>
        </div>
      </section>
    </div>
    <ConfirmModal :id="deleteId" @confirmed="deleteItem"></ConfirmModal>
  </div>
</template>
<script>
import { DELETED, UNPROCESSABLE_ENTITY, OK } from '@/util'
import WorkTableLayout from '@/layouts/WorkTableLayout'
import ConfirmModal from '@/components/modal/ConfirmModal'
import matches from '@/mixins/matches'
import reviewCalc from '@/mixins/reviewCalc'
export default {
  components: {
    WorkTableLayout,
    ConfirmModal,
  },
  mixins: [matches, reviewCalc],
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
      hasPost: true,
      deleteId: null,
    }
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.worksByOwner()
        await this.setMatches()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async worksByOwner() {
      const response = await axios.get(
        `/api/customers/${this.customer.id}/works`
      )
      if (response.status !== OK) {
        this.hasPost = false
      } else {
        this.works = response.data.data
        this.hasPost = !!this.works.length
      }
    },
    openDeleteModal(id) {
      this.deleteId = id
      this.$store.commit('form/setConfirmModal', {
        isShow: true,
        exeText: '削除',
      })
    },
    async deleteItem(id) {
      this.$store.commit('form/setIsLoading', true)
      const response = await axios.delete(`/api/works/${id}`)
      this.deleteId = null
      if (response.status === DELETED) {
        await this.worksByOwner()
        this.$store.commit('form/setIsLoading', false)
        this.$store.commit('form/setDeleteMessage', '削除しました')
      } else if (response.status === UNPROCESSABLE_ENTITY) {
        this.$store.commit('error/setMessage', response.data.errors)
        this.$store.commit('form/setIsLoading', false)
      } else {
        this.$store.commit('error/setErrors', {
          message: response,
          status: response.status,
        })
        this.$store.commit('form/setIsLoading', false)
      }
    },
  },
}
</script>
