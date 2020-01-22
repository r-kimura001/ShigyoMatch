<template>
  <div class="p-matches">
    <section class="MypageContent_box">
      <h3 class="MypageContent_title">
        <span>マッチした案件</span>
      </h3>
      <div class="MypageContent_body">
        <div class="Table">
          <table>
            <thead>
            <tr>
              <th class="Table_headText">あなたは</th>
              <th class="Table_headText">募集タイトル</th>
              <th class="Table_headText">お相手</th>
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
                  :to="`/works/${apply.work.id}`"
                  tag="span"
                  class="Table_dataText --link --hasIcon"
                  :style="bgImage(apply.work.file_name)"
                >
                  {{ apply.work.title }}
                </RouterLink>
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
                <div class="Table_dataText">{{ apply.updated_at }}</div>
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
                  @onClickClose="closeModal"></ReviewFormLayout>
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
  import { OK } from '@/util'
  import styles from '@/mixins/styles'
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
  mixins: [ styles ],
  data(){
    return {
      applies: null,
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
      hasData: true,
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
    async setMatches(){
      // 申し込み側
      const matchApplies = await this.matches()
      // 募集側
      const matchedApplies = await this.matcheds()

      this.applies = matchApplies.concat(matchedApplies)
      this.hasData = this.applies.length
    },
    async matches(){
      const response = await axios.get(`/api/customers/${this.customer.id}/matches`)
      if(response.status === OK ){
        return Object.keys(response.data).map( key => response.data[key]).map( apply => {
          apply.status = this.applierStatus
          return apply
        })
      }else{
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response,
        })
      }
    },
    async matcheds(){
      const response = await axios.get(`/api/customers/${this.customer.id}/matcheds`)
      if(response.status === OK ){
        return response.data.map( apply => {
          apply.status = this.recruiterStatus
          return apply
        })
      }else{
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response,
        })
      }
    },
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
    reviewResult(apply){
      return apply.is_review ? 'レビュー済み' : 'レビューを書く'
    }
  }

}
</script>
