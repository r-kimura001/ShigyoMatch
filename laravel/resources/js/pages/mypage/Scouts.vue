<template>
  <div class="p-scouts">
    <h2 class="MypageContent_heading">スカウト</h2>
    <section class="MypageContent_box">
      <div class="MypageContent_tabs">
        <Tab
          :current-flag="currentFlag"
          :apply-flag="scoutedFlag"
          :recruit-flag="scoutFlag"
          @tabClick="change"
        ></Tab>
      </div>
      <div v-if="currentFlag===scoutedFlag" class="MypageContent_body">
        <h3 class="BaseTitle">
          <span class="BaseTitle_text --scout">スカウトを受けた案件</span>
        </h3>
        <p v-if="!hasScouted" class="u-pa20">スカウトを受けた案件はありません</p>
        <div v-else class="">
          <ul class="ScoutList">
            <li
              v-for="(work, index) in scouted_works"
              :key="index"
              class="ScoutList_item"
              :class="{'--isNew': isNew(work.pivot.updated_at)}">
              <div class="ScoutList_targetInfo"
              >
                <ReplacedDate
                  action="スカウトを受けた"
                  :datetime="work.pivot.updated_at"
                ></ReplacedDate>
                <div class="ScoutList_message u-mt10">
                  <div class="">
                    <MemberLink :customer="work.customer"></MemberLink>
                  </div>
                  <div class="ScoutList_messagePart">
                    <span>さんからスカウトが届きました</span>
                  </div>
                </div>
              </div>
              <div class="ScoutList_scoutInfo">
                <div class="HorizontalLayout --vertical">
                  <div class="HorizontalLayout_col">
                    <div class="ScoutList_scoutThumb" :style="bgImage(work.file_name, 'work')"></div>
                  </div>
                  <div class="HorizontalLayout_col --flex">
                    <RouterLink :to="`/works/${work.id}`" tag="p" class="ScoutList_workLink u-ml10">{{ work.title }}</RouterLink>
                  </div>
                </div>
                <div class="ScoutList_detailButton">
                  <button class="Button --minimum u-ml10" @click="showDetail(work.pivot)">スカウト詳細</button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div  v-if="currentFlag===scoutFlag" class="MypageContent_body">
        <h3 class="BaseTitle">
          <span class="BaseTitle_text --scout">スカウトした案件</span>
        </h3>
        <p v-if="!hasScout" class="u-pa20">スカウトした案件はありません</p>
        <div v-else class="">
          <ul class="ScoutList">
            <li v-for="(targetUser, idx) in scout_works" :key="idx" class="ScoutList_item">
              <div class="ScoutList_targetInfo">
                <ReplacedDate
                  action="スカウト"
                  :datetime="targetUser.pivot.updated_at"
                ></ReplacedDate>
                <div class="ScoutList_message u-mt10">
                  <div class="">
                    <MemberLink :customer="targetUser"></MemberLink>
                  </div>
                  <div class="ScoutList_messagePart">
                    <span>さんにスカウトを送りました</span>
                  </div>
                </div>
              </div>
              <div class="ScoutList_scoutInfo">
                <div class="HorizontalLayout --vertical">
                  <div class="HorizontalLayout_col">
                    <div class="ScoutList_scoutThumb" :style="bgImage(targetUser.work.file_name, 'work')"></div>
                  </div>
                  <div class="HorizontalLayout_col --flex">
                    <RouterLink :to="`/works/${targetUser.work.id}`" tag="p" class="ScoutList_workLink u-ml10">{{ targetUser.work.title }}</RouterLink>
                  </div>
                </div>
                <div class="ScoutList_detailButton">
                  <button class="Button --minimum" @click="showDetail(targetUser.pivot)">スカウト詳細</button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <ScoutDetail
      :scout="currentScout"
      @onClickOut="currentScout = null"
    ></ScoutDetail>
  </div>
</template>
<script>
  import { OK, isNew } from '@/util'
  import ScoutDetail from '@/pages/mypage/ScoutDetail'
  import WorkListLayout from '@/layouts/WorkListLayout'
  import CustomerListLayout from '@/layouts/CustomerListLayout'
  import Tab from '@/components/Tab'
  import MemberLink from '@/components/MemberLink'
  import ReplacedDate from '@/components/ReplacedDate'
  import styles from '@/mixins/styles'
  export default {
    components: { ScoutDetail, WorkListLayout, CustomerListLayout, Tab, MemberLink, ReplacedDate },
    mixins: [styles],
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({}),
      },
    },
    data() {
      return {
        scout_works: [],
        scouted_works: [],
        currentScout: null,
        hasScout: true,
        hasScouted: true,
        scoutedFlag: 0,
        scoutFlag: 1,
        currentFlag: 0
      }
    },
    watch: {
      $route: {
        async handler() {
          this.$store.commit('form/setIsLoading', true)
          await this.scoutWorks()
          await this.scoutedWorks()
          this.$store.commit('form/setIsLoading', false)
        },
        immediate: true,
      },
    },
    computed: {
      scouts(){
        const customer = this.scout_works.map( work => work.scouts )
        return customer[0]
      }
    },
    methods: {
      async scoutWorks() {
        const response = await axios.get(
          `/api/customers/${this.customer.id}/pageless_works`
        )
        if (response.status !== OK) {
          this.hasScout = false
        } else {
          const works = response.data.filter(work => !!work.scouts.length)
          this.scout_works = works.map( work => {
            work.scouts.forEach( targetCustomer => {
              targetCustomer.work = {
                id: work.id,
                title: work.title,
                fee: work.fee,
                file_name: work.file_name,
              }
            })
            return work.scouts
          }).flat()
          this.scout_works.sort( (a, b) => a.pivot.created_at < b.pivot.created_at ? 1 : -1)
          this.hasScout = !!this.scout_works.length
        }
      },
      async scoutedWorks() {
        const response = await axios.get(
          `/api/customers/${this.customer.id}/scouted`
        )
        if (response.status !== OK) {
          this.hasScouted = false
        } else {
          const works = response.data
          this.scouted_works = Object.keys(works).map(key => works[key])
          this.hasScouted = !!Object.keys(this.scouted_works).length
        }
      },
      change(flag) {
        this.currentFlag = flag
      },
      showDetail(scout){
        this.currentScout = scout
      },
      isNew(datetime){
        return isNew(datetime)
      }
    }
  }
</script>
