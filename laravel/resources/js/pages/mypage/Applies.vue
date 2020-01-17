<template>
  <div class="p-applys">
    <h2>Favorites</h2>
    <section class="MypageContent_box">
      <div class="HorizontalLayout">
        <div class="HorizontalLayout_col">
          <h3 class="Tab" @click="change(applyFlag)">申込した</h3>
        </div>
        <div class="HorizontalLayout_col">
          <h3 class="Tab" @click="change(appliedFlag)">申込された</h3>
        </div>
      </div>
      <div>
        <div v-if="currentFlag===applyFlag" class="">
          <p v-if="!hasApplyWorks">申込をした募集案件はありません</p>
          <WorkListLayout
            v-else
            :works="apply_works"
          ></WorkListLayout>
        </div>
        <div v-if="currentFlag===appliedFlag">
          <p v-if="!hasAppliedWorks">申込をされた募集案件はありません</p>
          <WorkTableLayout
            v-else
            :works="applied_works"
          ></WorkTableLayout>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import { OK } from '@/util'
  import WorkListLayout from '@/layouts/WorkListLayout'
  import WorkTableLayout from '@/layouts/WorkTableLayout'
  export default {
    components: { WorkListLayout, WorkTableLayout },
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({}),
      },
    },
    data() {
      return {
        apply_works: [],
        applied_works: [],
        hasApplyWorks: true,
        hasAppliedWorks: true,
        applyFlag: 0,
        appliedFlag: 1,
        currentFlag: 0
      }
    },
    watch: {
      $route: {
        async handler() {
          this.$store.commit('form/setIsLoading', true)
          await this.applyWorks()
          await this.appliedWork()
          this.$store.commit('form/setIsLoading', false)
        },
        immediate: true,
      },
    },
    methods: {
      async applyWorks() {
        const response = await axios.get(
          `/api/customers/${this.customer.id}/applyWorks`
        )
        if (response.status !== OK) {
          this.hasApplyWorks = false
        } else {
          const works = response.data
          this.apply_works = Object.keys(works).map( key => works[key])
          this.hasApplyWorks = !!Object.keys(this.apply_works).length
        }
      },
      async appliedWork() {
        const response = await axios.get(
          `/api/customers/${this.customer.id}/works`
        )
        if (response.status !== OK) {
          this.hasAppliedWorks = false
        } else {
          this.applied_works = response.data.filter(work => !!work.appliers.length)
          this.hasAppliedWorks = !!this.applied_works.length
        }
      },
      change(flag){
        this.currentFlag = flag
      }
    },
  }
</script>
