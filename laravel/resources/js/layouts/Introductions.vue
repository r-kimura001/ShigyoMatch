<template>
  <ul class="Introductions">
    <li
      class="Introductions_item"
      v-for="(item, index, key) in introductions"
      :key="key"
      :style="visible(key)">
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
</template>
<script>
  import { BASE_STORAGE_URL } from "@/util"
  import styles from "@/mixins/styles"
  export default {
    mixins: [styles],
    data(){
      return {
        introductions: {
          1: {
            title: '案件募集・スカウト機能',
            desc: '案件とマッチしそうな事務所をスカウトしてみましょう。\n募集内容に興味を持ったお相手からは、申込が届きます。',
            image: 'assets/lawyer.svg',
            link: {
              text: '人材のお探しの方',
              path: '/customers',
              class: {
                '--pink': true
              }
            }
          },
          2: {
            title: '申込・メッセージ機能',
            desc: '掲載中の案件にたくさん応募しましょう。\nお相手の目に留まればメッセージが開通します',
            image: `assets/message.svg`,
            link: {
              text: '案件をお探しの方',
              path: '/works',
              class: {
                '--blue': true
              }
            }
          },
          3: {
            title: 'レビュー・フォロー機能',
            desc: '高評価やフォロワーが増えると、さらなる案件獲得につながります。\nまずはプロフィールを充実させましょう',
            image: `assets/smile_review.svg`,
            link: {
              text: '人材のお探しの方',
              path: '/customers',
              class: {
                '': true
              }
            }
          },
        }
      }
    },
    methods: {
      visible(key){
        const base = 2
        const interval = 0.3
        const delay = key * interval + base
        return {
          animationDelay: `${delay}s`
        }
      }
    }
  }
</script>
