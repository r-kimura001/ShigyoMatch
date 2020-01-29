<template>
  <div class="CustomerInfoLayout">
    <div class="CustomerInfoLayout_heading">
      <div class="CustomerInfoLayout_headingBox">
        <div
          class="CustomerInfoLayout_thumb"
          :style="{
            backgroundImage: `url(${thumbSrc(customer.file_name)})`,
          }"
        ></div>
        <h2 class="CustomerInfoLayout_name">
          {{ customer.name }}
        </h2>
        <p class="CustomerInfoLayout_greeting">
          {{ customer.greeting }}
        </p>
        <Review :score="averageReview" class="u-pb20" v-if="hasReview"></Review>
        <p class="Text -fz12 -nodata u-alignCenter u-pb20" v-else>レビューはありません</p>
        <div class="HorizontalLayout --justifyCenter">
          <div class="HorizontalLayout_col">
            <FollowButton
              :id="customer.id"
              :author="author"
              :isFollow="isFollow"
              v-if="!self"
              @followClick="followClick"
            ></FollowButton>
          </div>
          <div class="HorizontalLayout_col u-ml5">
            <ScoutButton
              :id="customer.id"
              :author="author"
              v-if="!self"
            ></ScoutButton>
          </div>
        </div>
      </div>
      <!-- CustomerInfoLayout_headingBox -->
      <div class="CustomerInfoLayout_headingBox">
        <h3
          class="CustomerInfoLayout_label"
          :style="bgImage('assets/icon-license.svg')"
        >
          資格
        </h3>
        <ul class="CustomerInfoLayout_skills">
          <li
            v-for="(professionType, index) in professionTypes"
            :key="index"
            class="CustomerInfoLayout_skill"
          >
            <div class="CustomerInfoLayout_skillTag">
              <span class="Tag" :style="bgColor(professionType.id)">
                {{ professionType.body }}
              </span>
            </div>
            <div class="CustomerInfoLayout_skillNum">{{ professionType.pivot.register_number }}</div>
          </li>
        </ul>
      </div>
      <!-- CustomerInfoLayout_headingBox -->
      <div class="CustomerInfoLayout_headingBox">
        <h3
          class="CustomerInfoLayout_label"
          :style="bgImage('assets/icon-license-card.svg')"
        >
          スコア
        </h3>
        <ul class="HorizontalLayout u-py10">
          <li class="HorizontalLayout_col --equal">
            <h4 class="Text -fz12 -bold u-alignCenter u-h20">
              <img
                :src="imageSrc('icon-follow3.png')"
                width="20px"
                class="u-mr5"
                alt="icon_follower"
              />
              <span>フォロワー</span>
            </h4>
            <RouterLink :to="`/customers/${customer.id}/followers`" tag="p" class="Text -deepGreen -bold u-alignCenter">
              {{ customer.followers.length }}
            </RouterLink>
          </li>
          <li class="HorizontalLayout_col --equal">
            <h4 class="Text -fz12 -bold u-alignCenter u-h20">
              <img
                :src="imageSrc('icon-match.svg')"
                width="20px"
                class="u-mr5"
                alt="icon_follower"
              />
              <span>受託件数</span>
            </h4>
            <p class="Text -deepGreen -bold u-alignCenter">{{ customer.match_count }}</p>
          </li>
        </ul>
      </div>
      <!-- CustomerInfoLayout_headingBox -->
      <div class="CustomerInfoLayout_headingBox">
        <h3
          class="CustomerInfoLayout_label"
          :style="bgImage('assets/icon-map.svg')"
        >
          所在地
        </h3>
        <p class="CustomerInfoLayout_text">{{ customer.full_address }}</p>
      </div>
      <!-- CustomerInfoLayout_headingBox -->
      <div class="CustomerInfoLayout_headingBox">
        <h3
          class="CustomerInfoLayout_label"
          :style="bgImage('assets/icon-website.svg')"
        >
          URL
        </h3>
        <a :href="customer.url" target="_blank" class="CustomerInfoLayout_link">{{
          customer.url
        }}</a>
      </div>
      <!-- CustomerInfoLayout_headingBox -->
    </div>
    <!-- CustomerInfoLayout_heading -->
    <div class="CustomerInfoLayout_main">
      <section class="CustomerInfoLayout_mainBox">
        <h2 class="BaseTitle">
          <span class="BaseTitle_text --work">募集中の案件</span>
        </h2>
        <p v-if="!hasData">募集中の案件はありません</p>
        <div v-else>
          <Pager
            v-if="lastPage > 1"
            :current-page="currentPage"
            :last-page="lastPage"
            path="works"
          ></Pager>
          <WorkListLayout :works="list"></WorkListLayout>
        </div>
      </section>
      <section class="CustomerInfoLayout_mainBox u-mt50">
        <h2 class="BaseTitle">
          <span class="BaseTitle_text --review">{{ customer.name }}さんへのレビュー</span>
        </h2>
        <ul class="ReviewListLayout">
          <li v-if="!hasReview" class="Text -nodata -fz14">レビューはありません</li>
          <li
            v-else
            class="ReviewListLayout_item"
            v-for="(review, index) in reviewers"
            :key="index">
            <div class="ReviewListLayout_comment">{{ review.comment }}</div>
            <div class="ReviewListLayout_heading">
              <div class="ReviewListLayout_reviewer">
                <MemberLink :customer="review.reviewer"></MemberLink>
              </div>
              <div class="ReviewListLayout_point">
                <Review :score="review.point" :small="true"></Review>
              </div>
            </div>
          </li>
        </ul>
      </section>
    </div>
    <!-- CustomerInfoLayout_main -->
  </div>
  <!-- CustomerInfoLayout -->
</template>
<script>
import { BASE_STORAGE_URL, OK } from '@/util'
import { mapGetters, mapState } from 'vuex'
import apiIndexHandler from '@/mixins/apiIndexHandler'
import reviewCalc from '@/mixins/reviewCalc'
import styles from '@/mixins/styles'
import FollowButton from '@/components/FollowButton'
import MemberLink from '@/components/MemberLink'
import Pager from '@/components/Pager'
import Review from '@/components/Review'
import ScoutButton from '@/components/ScoutButton'
import WorkListLayout from '@/layouts/WorkListLayout'
export default {
  components: {
    FollowButton,
    Pager,
    MemberLink,
    Review,
    ScoutButton,
    WorkListLayout,
  },
  mixins: [styles, apiIndexHandler, reviewCalc],
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  computed: {
    ...mapGetters({
      isLogin: 'auth/isLogin',
    }),
    ...mapState({
      author: state => state.auth.customer
    }),
    professionTypes() {
      return this.customer.profession_types
    },
    self(){
      if(!this.isLogin){
        return false
      }
      return this.customer.id === this.author.id
    },
    isFollow(){
      let isFollow = false
      if(!this.customer.followers.length){
        return false
      }
      this.customer.followers.forEach(follower => {
        if(follower.id === this.author.id){
          isFollow = true
        }
      })
      return isFollow
    },
  },
  methods: {
    imageSrc(src) {
      return `${BASE_STORAGE_URL}/assets/${src}`
    },
    async followClick(){
      if(this.isFollow){
        await this.unfollow()
      }else{
        await this.follow()
      }
    },
    async follow(){
      const response = await axios.put(`/api/customers/${this.customer.id}/follow`)
      this.$store.commit('form/setResponse', response)
      if(response.status === OK){
        this.customer.followers = response.data.followers
      }else{
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response,
        })
      }
    },
    async unfollow(){
      const response = await axios.delete(`/api/customers/${this.customer.id}/unfollow`)
      this.$store.commit('form/setResponse', response)
      if(response.status === OK){
        this.customer.followers = response.data.followers
      }else{
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response,
        })
      }
    },
  },
}
</script>
