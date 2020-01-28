<template>
  <div class="p-scouts">
    <h2>Scouts</h2>
    <section class="MypageContent_box">
      <div class="MypageContent_tabs">
        <Tab
          :current-flag="currentFlag"
          :apply-flag="scoutedFlag"
          :recruit-flag="scoutFlag"
          @tabClick="change"
        ></Tab>
      </div>
      <div v-if="currentFlag===scoutedFlag" class="MypageContent_body u-bgBlue">
        <h3 class="BaseTitle">
          <span class="BaseTitle_text --scout">スカウトを受けた案件</span>
        </h3>
        <p v-if="!hasScouted" class="u-pa20">スカウトを受けた案件はありません</p>
        <div v-else class="u-py20">
          <ul v-for="(work, index) in scouted_works" :key="index" class="ScoutList">
            <li class="ScoutList_item">
              <div class="ScoutList_targetInfo">{{ work.customer.name }}</div>
              <div class="ScoutList_scoutInfo">
                <div class="ScoutList_scoutThumb" :style="bgImage(work.file_name, 'work')"></div>
                <p class="ScoutList_text u-ml20">{{ work.pivot.title }}</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div  v-if="currentFlag===scoutFlag" class="MypageContent_body u-bgGray">
        <h3 class="BaseTitle">
          <span class="BaseTitle_text --scout">スカウトした案件</span>
        </h3>
        <p v-if="!hasScout" class="u-pa20">スカウトした案件はありません</p>
        <div v-else class="u-py20">
          <ul v-for="(work, index) in scout_works" :key="index" class="ScoutList">
            <li v-for="(targetCustomer, idx) in work.scouts" :key="idx" class="ScoutList_item">
              <div class="ScoutList_targetInfo">{{ targetCustomer.name }}</div>
              <div class="ScoutList_scoutInfo">
                <div class="ScoutList_targetThumb" :style="bgImage(targetCustomer.file_name)"></div>
                <p class="ScoutList_text u-ml20">{{ targetCustomer.pivot.title }}</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import { OK } from '@/util'
  import WorkListLayout from '@/layouts/WorkListLayout'
  import CustomerListLayout from '@/layouts/CustomerListLayout'
  import Tab from '@/components/Tab'
  import styles from '@/mixins/styles'
  export default {
    components: { WorkListLayout, CustomerListLayout, Tab },
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
          this.scout_works = response.data.filter(work => !!work.scouts.length)
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
      }
    }
  }
</script>
