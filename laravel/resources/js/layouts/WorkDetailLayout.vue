<template>
  <div class="WorkDetailLayout">
    <div class="WorkDetailLayout_box">
      <div class="WorkDetailLayout_heading" :style="{ backgroundImage: `url(${thumbSrc(work.file_name)})` }">
        <h2 class="WorkDetailLayout_title">{{ work.title }}</h2>
        <p class="WorkDetailLayout_customer">{{ work.customer.name }}</p>
        <div
          v-if="showable"
          class="WorkDetailLayout_mark"
          :class="{ '--favorite': work.is_favorite }"
          @click="onClickStar"></div>
      </div>
      <div class="WorkDetailLayout_body">
        <dl class="WorkDetailLayout_list">
          <dt class="WorkDetailLayout_listTerm">
            <span class="WorkDetailLayout_listText">資格</span>
          </dt>
          <dd class="WorkDetailLayout_listDesc">
            <div class="Tag u-ma5" :style="bgColor(work.profession_type.id)">{{ work.profession_type.body }}</div>
          </dd>
        </dl>
        <dl class="WorkDetailLayout_list">
          <dt class="WorkDetailLayout_listTerm">分野</dt>
          <dd class="WorkDetailLayout_listDesc">
            <div class="HorizontalLayout --wrap">
              <div class="HorizontalLayout_col" v-for="(skill, index) in work.skills" :key="index">
                <div class="Tag u-ma5">{{ skill.body }}</div>
              </div>
            </div>
          </dd>
        </dl>
        <dl class="WorkDetailLayout_list">
          <dt class="WorkDetailLayout_listTerm">報酬</dt>
          <dd class="WorkDetailLayout_listDesc">{{ work.fee.toLocaleString() }}円</dd>
        </dl>
        <dl class="WorkDetailLayout_list">
          <dt class="WorkDetailLayout_listTerm">募集要項</dt>
          <dd class="WorkDetailLayout_listDesc">{{ work.body }}</dd>
        </dl>
        <dl class="WorkDetailLayout_list">
          <dt class="WorkDetailLayout_listTerm">募集者情報</dt>
          <dd class="WorkDetailLayout_listDesc --column">
            <div class="WorkDetailLayout_customerThumb">
              <img :src="thumbSrc(customer.file_name)" alt="">
            </div>
            <dl class="WorkDetailLayout_customerList u-py10">
              <dt class="WorkDetailLayout_customerTitle">
                <p class="Text -gray -fz12 -bold">
                  <img class="u-icon" :src="thumbSrc('assets/icon-office.svg')" alt="">
                </p>
              </dt>
              <dd class="WorkDetailLayout_customerDesc">
                <RouterLink :to="`/customers/${customer.id}`" tag="p" class="Text -link -fz12 -bold">{{ customer.name }}</RouterLink>
              </dd>
            </dl>
            <dl class="WorkDetailLayout_customerList u-pb10">
              <dt class="WorkDetailLayout_customerTitle">
                <p class="Text -gray -fz12 -bold">
                  <img class="u-icon" :src="thumbSrc('assets/icon-map.svg')" alt="">
                </p>
              </dt>
              <dd class="WorkDetailLayout_customerDesc">
                <p class="Text -gray -fz12 -bold">{{ customer.full_address }}</p>
              </dd>
            </dl>
            <dl class="WorkDetailLayout_customerList">
              <dt class="WorkDetailLayout_customerTitle">
                <p class="Text -gray -fz12 -bold">
                  <img class="u-icon" :src="thumbSrc('assets/icon-website.svg')" alt="">
                </p>
              </dt>
              <dd class="WorkDetailLayout_customerDesc">
                <p class="Text -gray -fz12 -bold"><a :href="customer.url" target="_blank">{{ customer.url }}</a></p>
              </dd>
            </dl>
          </dd>
        </dl>
      </div>
    </div>
  </div>
</template>
<script>
  import { OK } from '@/util'
  import worksData from '@/mixins/worksData'
  import styles from '@/mixins/styles'
  export default {
    computed: {
      customer(){
        return this.work.customer
      },
    },
    mixins: [styles, worksData],
    methods: {
      onClickStar() {
        if (!this.isLogin) {
          alert('気になる機能を使うにはログインしてください')
          return false
        } else if (this.work.is_favorite) {
          this.unfavorite()
        } else {
          this.favorite()
        }
      },
      async favorite() {
        const response = await axios.put(`/api/works/${this.work.id}/favorite`)
        if (response.status === OK) {
          this.work.is_favorite = response.data.is_favorite
        } else {
          this.$store.commit('error/setErrors', {
            message: response,
            status: response.status,
          })
        }
      },
      async unfavorite() {
        const response = await axios.delete(
          `/api/works/${this.work.id}/unfavorite`
        )
        if (response.status === OK) {
          this.work.is_favorite = response.data.is_favorite
        } else {
          this.$store.commit('error/setErrors', {
            message: response,
            status: response.status,
          })
        }
      },
    },
  }
</script>
