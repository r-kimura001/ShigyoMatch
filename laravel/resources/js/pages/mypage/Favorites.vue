<template>
  <div class="p-favorites">
    <h2 class="MypageContent_heading">お気に入り履歴</h2>
    <section class="MypageContent_box">
      <div class="MypageContent_tabs">
        <Tab
          :current-flag="currentFlag"
          :apply-flag="favoriteFlag"
          :recruit-flag="favoritedFlag"
          @tabClick="change"
        ></Tab>
      </div>
      <div v-if="currentFlag===favoriteFlag" class="MypageContent_body u-bgGray">
        <h3 class="BaseTitle u-px10">
          <span class="BaseTitle_text --favorite">気になるした案件</span>
        </h3>
        <p v-if="!hasFavorite">気になるした募集案件はありません</p>
        <WorkListLayout
          v-else
          :works="favorite_works"
          class="u-pa10"
        ></WorkListLayout>
      </div>
      <div v-if="currentFlag===favoritedFlag" class="MypageContent_body">
        <h3 class="BaseTitle u-px10">
          <span class="BaseTitle_text --favorite">気になるされた案件</span>
        </h3>
        <p v-if="!hasFavorited">気になるされた募集案件はありません</p>
        <ul v-else class="FavoritedList u-py20">
          <li
            class="FavoritedList_item"
            v-for="(favorite, index) in favorited_members"
            :key="index"
            :class="{'--isNew': isNew(favorite.pivot.created_at)}"
          >
            <div class="FavoritedList_body u-px10">
              <div class="FavoritedList_member">
                <MemberLink :customer="favorite" unit="さんから「気になる」が届きました"></MemberLink>
              </div>
              <div class="FavoritedList_work">
                <div class="FavoritedList_workThumb" :style="bgImage(favorite.work.file_name, 'work')"></div>
                <RouterLink :to="`/works/${favorite.work.id}`" class="Text -blue u-mx5">{{ favorite.work.title }}</RouterLink>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </section>
  </div>
</template>
<script>
import { OK, isNew } from '@/util'
import styles from '@/mixins/styles'
import MemberLink from '@/components/MemberLink'
import WorkListLayout from '@/layouts/WorkListLayout'
import Tab from '@/components/Tab'

export default {
  components: {
    MemberLink,
    WorkListLayout,
    Tab
  },
  mixins: [ styles ],
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
      favorited_members: [],
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
        await this.favoritedWorks()
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
        this.favorite_works = Object.keys(response.data).map( key => response.data[key] )
        this.hasFavorite = !!this.favorite_works.length
      }
    },
    async favoritedWorks() {
      const response = await axios.get(
        `/api/customers/${this.customer.id}/favoritedWorks`
      )
      if (response.status !== OK) {
        this.hasFavorited = false
      } else {
        this.favorited_members = Object.keys(response.data).map( key => {
          response.data[key].favorites.forEach( favorite => {
            favorite.work = {
              id: response.data[key].id,
              title: response.data[key].title,
              file_name: response.data[key].file_name,
            }
          })
          return response.data[key].favorites
        }).flat()
        this.favorited_members.sort( (a, b) => a.pivot.created_at < b.pivot.created_at ? 1 : -1)
        this.hasFavorited = !!this.favorited_members.length
      }
    },
    change(flag){
      this.currentFlag = flag
    },
    isNew(datetime){
      return isNew(datetime)
    }
  },
}
</script>
