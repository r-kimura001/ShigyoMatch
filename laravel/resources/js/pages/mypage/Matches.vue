<template>
  <div class="p-matches u-pa20">
    <section class="MypageContent_box">
      <h3 class="MypageContent_title u-pa20">
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
              <th class="Table_headText">申込日時</th>
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
                <div class="Table_dataText">{{ apply.created_at }}</div>
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
      hasData: true,
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
        return response.data.map( apply => {
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
    }
  }

}
</script>
