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
          <button class="Button --green --minimum">
            スカウト
          </button>
          <button class="BorderButton --minimum">フォロー</button>
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
              12
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
              <span>マッチ数</span>
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
        <a :href="customer.url" class="CustomerInfoLayout_link">{{
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
      <Pager
        v-if="lastPage > 1"
        :current-page="currentPage"
        :last-page="lastPage"
      ></Pager>
      <WorkListLayout :works="works"></WorkListLayout>
    </div>
    <!-- CustomerInfoLayout_main -->
  </div>
  <!-- CustomerInfoLayout -->
</template>
<script>
import { BASE_STORAGE_URL } from '@/util'
import styles from '@/mixins/styles'
import WorkListLayout from '@/layouts/WorkListLayout'
import Pager from '@/components/Pager'
export default {
  components: {
    WorkListLayout,
    Pager,
  },
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
      works: [
        {
          id: 1,
          title: '任意整理の経験者募集',
          fee: 50000,
          file_name: '',
        },
        {
          id: 2,
          title: '破産申立の経験者募集',
          fee: 25000,
          file_name: '',
        },
        {
          id: 3,
          title: '過払い金請求業務',
          fee: 100000,
          file_name: '',
        },
        {
          id: 4,
          title: '相続登記',
          fee: 200000,
          file_name: '',
        },
        {
          id: 5,
          title: '会社設立全般',
          fee: 50000,
          file_name: '',
        },
        {
          id: 6,
          title: '電子定款の作成経験者募集',
          fee: 10000,
          file_name: '',
        },
        {
          id: 7,
          title: '企業法務全般',
          fee: 50000,
          file_name: '',
        },
      ],
      from: null,
      to: null,
      currentPage: null,
      lastPage: null,
    }
  },
  computed: {
    professionTypes() {
      return this.customer.profession_types
    },
  },
  methods: {
    imageSrc(src) {
      return `${BASE_STORAGE_URL}/assets/${src}`
    },
  },
}
</script>
