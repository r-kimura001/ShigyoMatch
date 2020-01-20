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
        <div class="u-alignCenter">
          <ScoutButton :id="customer.id" v-if="!self"></ScoutButton>
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
        <ul>
          <li
            v-for="(professionType, index) in professionTypes"
            :key="index"
            class="CustomerInfoLayout_tag"
          >
            <p class="Tag" :style="bgColor(professionType.id)">
              {{ professionType.body }}
            </p>
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
            <p class="Text -deepGreen -bold u-alignCenter">
              {{ customer.follower_count }}
            </p>
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
            <p class="Text -deepGreen -bold u-alignCenter">
              2
            </p>
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
      <!-- header_title(「募集中の案件一覧」みたいな) -->
      <h2 class="CustomerInfoLayout_mainTitle">
        募集中の案件
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
    </div>
    <!-- CustomerInfoLayout_main -->
  </div>
  <!-- CustomerInfoLayout -->
</template>
<script>
import { BASE_STORAGE_URL, OK } from '@/util'
import { mapGetters, mapState } from 'vuex'
import styles from '@/mixins/styles'
import apiIndexHandler from '@/mixins/apiIndexHandler'
import WorkListLayout from '@/layouts/WorkListLayout'
import Pager from '@/components/Pager'
import ScoutButton from '@/components/ScoutButton'
export default {
  components: {
    WorkListLayout,
    Pager,
    ScoutButton
  },
  mixins: [styles, apiIndexHandler],
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
      return this.customer.id === this.author.id
    }
  },
  methods: {
    imageSrc(src) {
      return `${BASE_STORAGE_URL}/assets/${src}`
    },
  },
}
</script>
