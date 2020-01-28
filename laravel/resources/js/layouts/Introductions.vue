<template>
  <div v-if="isFadeout" class="Introductions">
    <h2
      class="BaseTitle --intro"
      :class="{ '--visible': isVisible.title}"
      v-observe-visibility="{
        callback: (isVisible, entry) => visibilityChanged(isVisible, entry, 'title'),
        once: true
      }"
    >
      <span class="BaseTitle_text --customer">サービスご紹介</span>
    </h2>
    <ul
      class="Introductions_body u-mt20"
    >
      <li
        class="Introductions_item"
        v-for="(item, key, index) in introductions"
        :key="key"
        v-observe-visibility="{
          callback: (isVisible, entry) => visibilityChanged(isVisible, entry, key),
          once: true
        }"
        :class="{ '--visible': isVisible[key]}"
        :style="delay(key)">
        <div class="Introductions_heading">
          <div class="Introductions_thumb" :style="bgImage(item.image)"></div>
        </div>
        <h3 class="Introductions_title">{{ item.title }}</h3>
        <p class="Introductions_desc">{{ item.desc }}</p>
        <div class="Introductions_link u-alignCenter">
          <RouterLink
            tag="button"
            :to="item.link.path"
            class="Button --small --hasShadow"
            :class="item.link.class">{{ item.link.text }}</RouterLink>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
  import { BASE_STORAGE_URL, CLIENT_WIDTH } from "@/util"
  import styles from "@/mixins/styles"
  export default {
    mixins: [styles],
    data(){
      return {
        introductions: {
          1: {
            title: '申込・メッセージ機能',
            desc: '掲載中の募集案件にどんどん応募しましょう。\nお相手の目に留まればメッセージが開通します',
            image: `assets/message.svg`,
            link: {
              text: '仕事をお探しの方',
              path: '/works',
              class: {
                '--blue': true
              }
            }
          },
          2: {
            title: '案件募集・スカウト機能',
            desc: '案件とマッチしそうな事務所をスカウトしてみましょう。\n募集内容に興味を持ったお相手からは、申込が届きます。',
            image: 'assets/lawyer.svg',
            link: {
              text: '人材をお探しの方',
              path: '/customers',
              class: {
                '--pink': true
              }
            }
          },
          3: {
            title: 'レビュー・フォロー機能',
            desc: '高評価やフォロワーが増えると、さらなる案件または人材獲得につながります。\nまずはプロフィールを充実させましょう',
            image: `assets/smile_review.svg`,
            link: {
              text: 'アカウントをお持ちの方',
              path: '/login',
              class: {
                '': true
              }
            }
          },
        },
        isVisible: {
          title: false,
          1: false,
          2: false,
          3: false,
        },
        isFadeout: false
      }
    },
    watch: {
      $route: {
        async handler() {
          setTimeout( () => {
            this.isFadeout = true
          }, 1100)
        },
        immediate: true
      },
    },
    methods: {
      delay(key){
        const base = 0.85
        const interval = 0.3
        const delay = key * interval + base
        return {
          transitionDelay: `${delay}s`
        }
      },
      visibilityChanged (isVisible, entry, key) {
        this.isVisible[key] = isVisible
        console.log(entry)
      },
    }
  }
</script>
