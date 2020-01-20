<template>
  <div class="p-favorites u-pa20">
    <h2>Favorites</h2>
    <section class="MypageContent_box">
      <div class="MypageContent_tabs">
        <Tab
          :current-flag="currentFlag"
          :apply-flag="favoriteFlag"
          :recruit-flag="favoritedFlag"
          @tabClick="change"
        ></Tab>
      </div>
      <div class="MypageContent_body">
        <div v-if="currentFlag===favoriteFlag" class="">
          <p v-if="!hasFavorite">気になるした募集案件はありません</p>
          <WorkListLayout
            v-else
            :works="favorite_works"
          ></WorkListLayout>
        </div>
        <div v-if="currentFlag===favoritedFlag">
          <p v-if="!hasFavorited">気になるされた募集案件はありません</p>
          <WorkTableLayout
            v-else
            :works="favorited_works"
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
import Tab from '@/components/Tab'

export default {
  components: { WorkListLayout, WorkTableLayout, Tab },
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  data() {
    return {
      favorite_works: [],
      favorited_works: [],
      hasFavorite: true,
      hasFavorited: true,
      favoriteFlag: 0,
      favoritedFlag: 1,
      currentFlag: 0
    }
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.favoriteWorks()
        await this.worksByOwner()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async favoriteWorks() {
      const response = await axios.get(
        `/api/customers/${this.customer.id}/favoriteWorks`
      )
      if (response.status !== OK) {
        this.hasFavorite = false
      } else {
        this.favorite_works = response.data
        this.hasFavorite = !!Object.keys(this.favorite_works).length
      }
    },
    async worksByOwner() {
      const response = await axios.get(
        `/api/customers/${this.customer.id}/works`
      )
      if (response.status !== OK) {
        this.hasFavorited = false
      } else {
        this.favorited_works = response.data.data
        this.hasFavorited = !!this.favorited_works.length
      }
    },
    change(flag){
      this.currentFlag = flag
    }
  },
}
</script>
