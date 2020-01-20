<template>
  <div class="p-applys u-pa20">
    <h2>Applies</h2>
    <section class="MypageContent_box">
      <div class="MypageContent_tabs">
        <Tab
          :current-flag="currentFlag"
          :apply-flag="applyFlag"
          :recruit-flag="appliedFlag"
          @tabClick="change"
        ></Tab>
      </div>
      <div class="MypageContent_body">
        <div v-if="currentFlag===applyFlag" class="">
          <p v-if="!hasApplyWorks">申込をした募集案件はありません</p>
          <div v-else class="Table">
            <table>
              <thead>
              <tr>
                <th class="Table_headText">操作</th>
                <th class="Table_headText">募集タイトル</th>
                <th class="Table_headText">募集者</th>
                <th class="Table_headText">申込日時</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(work, index) in apply_works" :key="index">
                <td>
                  <button
                    class="Button --minimum"
                    @click="showDetail(work.author_apply_info)"
                  >
                    詳細
                  </button>
                </td>
                <td>
                  <RouterLink
                    :to="`/works/${work.id}`"
                    tag="span"
                    class="Table_dataText --link --hasIcon"
                    :style="bgImage(work.file_name)"
                  >
                    {{ work.title }}
                  </RouterLink>
                </td>
                <td>
                  <RouterLink
                    :to="`/customers/${work.customer.id}`"
                    tag="span"
                    class="Table_dataText --link --hasIcon"
                    :style="bgImage(work.customer.file_name)"
                  >
                    {{ work.customer.name }}
                  </RouterLink>
                </td>
                <td>
                  <div class="Table_dataText">{{ work.author_apply_info.pivot.created_at }}</div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div v-if="currentFlag===appliedFlag">
          <p v-if="!hasAppliedWorks">申込を受けた募集案件はありません</p>
          <div v-else class="Table">
            <table>
              <thead>
              <tr>
                <th class="Table_headText">操作</th>
                <th class="Table_headText">募集タイトル</th>
                <th class="Table_headText">申込者</th>
                <th class="Table_headText">申込日時</th>
              </tr>
              </thead>
              <tbody>
                <tr v-for="(applier, index) in appliers" :key="index">
                  <td>
                    <button
                      class="Button --minimum"
                      @click="showDetail(applier)"
                    >
                      詳細
                    </button>
                  </td>
                  <td>
                    <RouterLink
                      :to="`/works/${applier.work.id}`"
                      tag="span"
                      class="Table_dataText --link --hasIcon"
                      :style="bgImage(applier.work.file_name)"
                    >
                      {{ applier.work.title }}
                    </RouterLink>
                  </td>
                  <td>
                    <RouterLink
                      :to="`/customers/${applier.id}`"
                      tag="span"
                      class="Table_dataText --link --hasIcon"
                      :style="bgImage(applier.file_name)"
                    >
                      {{ applier.name }}
                    </RouterLink>
                  </td>
                  <td>
                    <div class="Table_dataText">{{ applier.pivot.created_at }}</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <ApplyDetail
      :applier="detail"
      @onClickOut="detail = {}"
      @created="$router.push(`/mypage/${customer.id}/messages`)"></ApplyDetail>
  </div>
</template>
<script>
  import { OK } from '@/util'
  import styles from '@/mixins/styles'
  import WorkListLayout from '@/layouts/WorkListLayout'
  import WorkTableLayout from '@/layouts/WorkTableLayout'
  import Tab from '@/components/Tab'
  import ApplyDetail from '@/pages/mypage/ApplyDetail'

  export default {
    components: { WorkListLayout, WorkTableLayout, Tab, ApplyDetail },
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({}),
      },
    },
    mixins: [ styles ],
    data() {
      return {
        apply_works: [],
        applied_works: [],
        hasApplyWorks: true,
        hasAppliedWorks: true,
        applyFlag: 0,
        appliedFlag: 1,
        currentFlag: 0,
        detail: {}
      }
    },
    watch: {
      $route: {
        async handler() {
          this.$store.commit('form/setIsLoading', true)
          await this.applyWorks()
          await this.appliedWorks()
          this.$store.commit('form/setIsLoading', false)
        },
        immediate: true,
      },
    },
    computed:{
      appliers(){
        const appliers = this.applied_works.map( work => work.appliers).flat();

        // 申込者に紐づくwork
        appliers.forEach(applier => {
          const work = this.applied_works.filter(work => work.id === applier.pivot.work_id)
          applier.work = work[0]
        })
        // 申込日時降順で並べ替え(小さい=古い場合は、1を返す)
        appliers.sort( (a, b) => a.pivot.created_at < b.pivot.created_at ? 1 : -1)
        return appliers
      }
    },
    methods: {
      async applyWorks() {
        const response = await axios.get(
          `/api/customers/${this.customer.id}/apply_works`
        )
        if (response.status !== OK) {
          this.hasApplyWorks = false
        } else {
          const works = response.data
          this.apply_works = Object.keys(works).map( key => works[key])
          this.apply_works.forEach( work => {
            const applyInfo = work.appliers.filter(applier => applier.id === this.customer.id)
            work['author_apply_info'] = applyInfo[0]
          })
          this.hasApplyWorks = !!Object.keys(this.apply_works).length
        }
      },
      async appliedWorks() {
        const response = await axios.get(
          `/api/customers/${this.customer.id}/applied_works`
        )
        if (response.status !== OK) {
          this.hasAppliedWorks = false
        } else {
          this.applied_works = Object.keys(response.data).map( key => response.data[key] )
          this.hasAppliedWorks = !!this.applied_works.length
        }
      },
      change(flag){
        this.currentFlag = flag
      },
      showDetail(applier){
        this.detail = applier
      }
    },
  }
</script>
