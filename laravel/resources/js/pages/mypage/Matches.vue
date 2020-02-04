<template>
  <div class="p-matches">
    <h2 class="MypageContent_heading">マッチング履歴</h2>
    <section class="MypageContent_box">
      <h3 class="BaseTitle">
        <span class="BaseTitle_text --match">マッチした案件</span>
      </h3>
      <div class="MypageContent_body">
        <div class="Table">
          <table>
            <thead>
            <tr>
              <th class="Table_headText">あなたは</th>
              <th class="Table_headText">お相手</th>
              <th class="Table_headText">案件</th>
              <th class="Table_headText">最終更新日時</th>
              <th class="Table_headText">操作</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(apply, index) in applies" :key="index">
              <td>
                <span class="Tag" :style="bgColor(apply.status)">{{ label[apply.status] }}</span>
              </td>
              <td>
                <RouterLink
                  :to="`/customers/${target(apply).id}`"
                  tag="span"
                  class="Table_dataText --link --hasIcon"
                  :style="bgImage(target(apply).file_name)"
                >
                  {{ target(apply).name }}
                </RouterLink>
              </td>
              <td>
                <RouterLink
                  :to="`/works/${apply.work.id}`"
                  tag="span"
                  class="Table_dataText --link --hasIcon"
                  :style="bgImage(apply.work.file_name, 'work')"
                >
                  {{ apply.work.title }}
                </RouterLink>
              </td>
              <td>
                <div class="Table_dataText">{{ replacedDate(apply.updated_at) }}</div>
              </td>
              <td>
                <button
                  class="BorderButton --minimum --orange"
                  :class="{'--disable': apply.is_review}"
                  @click="showReviewForm(apply.id)"
                >
                  {{ reviewResult(apply) }}
                </button>
                <ReviewFormLayout
                  :apply="apply"
                  :reviewee="target(apply)"
                  :currentId="currentId"
                  @onClickClose="closeModal"
                  @onReviewed="fetchApply(apply)"
                ></ReviewFormLayout>
              </td>
            </tr>
            </tbody>
          </table>
          <p v-if="!hasData" class="u-pa20">マッチした募集案件はありません</p>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import ReviewFormLayout from '@/layouts/ReviewFormLayout'
import { OK, dateReplace } from '@/util'
import styles from '@/mixins/styles'
import matches from '@/mixins/matches'
export default {
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  components: {
    ReviewFormLayout
  },
  mixins: [ styles, matches ],
  data(){
    return {
      applierStatus: 1,
      recruiterStatus: 2,
      label: {
        1: '応募側',
        2: '募集側'
      },
      color: {
        1: '\#177cc0',
        2: '\#e4406f'
      },
      test: null,
      currentId: 0,
    }
  },
  watch: {
    $route: {
      async handler(){
        this.$store.commit('form/setIsLoading', true)
        await this.setMatches()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true
    }
  },
  methods: {
    target(apply){
      return apply.status === this.applierStatus ? apply.work.customer : apply.applier
    },
    bgColor(id){
      return {
        backgroundColor: this.color[id],
      }
    },
    showReviewForm(applyId){
      this.currentId = applyId
    },
    closeModal(){
      this.currentId = 0
    },
    fetchApply(apply){
      apply.is_review = true
      this.closeModal()
    },
    reviewResult(apply){
      return apply.is_review ? 'レビュー済み' : 'レビューを書く'
    },
    replacedDate(dateTime){
      return dateReplace(dateTime)
    }
  }

}
</script>
