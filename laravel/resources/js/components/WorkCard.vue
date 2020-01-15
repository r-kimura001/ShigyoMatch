<template>
  <div class="WorkCard" :data-fee="work.fee.toLocaleString()">
    <div
      v-if="!work.is_owner"
      class="WorkCard_mark"
      :class="{ '--favorite': work.is_favorite }"
      @click="onClickStar"
    ></div>
    <RouterLink :to="`/works/${work.id}`" tag="div" class="WorkCard_face">
      <div class="WorkCard_thumb">
        <img :src="thumbSrc(work.file_name)" alt="" />
      </div>
    </RouterLink>
    <div class="WorkCard_cover">
      <div class="WorkCard_text">
        <p class="WorkCard_title">{{ work.title }}</p>
        <p class="WorkCard_time">2020年1月20日</p>
      </div>
      <div class="WorkCard_button">
        <button class="BorderButton --minimum --yellow">気になる</button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import { OK } from '@/util'
import styles from '@/mixins/styles'
export default {
  mixins: [styles],
  props: {
    work: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  computed: {
    ...mapGetters({
      isLogin: 'auth/isLogin',
    }),
  },
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
