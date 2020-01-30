<template>
  <div class="WorkCard" :data-fee="work.fee.toLocaleString()">
    <div
      v-if="showable"
      class="WorkCard_mark u-tip --bottom"
      :class="{ '--favorite': work.is_favorite }"
      @click="onClickStar"
      :data-desc="favoriteStatus"
    ></div>
    <RouterLink :to="`/works/${work.id}`" tag="div" class="WorkCard_face">
      <div class="WorkCard_thumb">
        <img :src="thumbSrc(work.file_name, 'work')" alt="work.image" />
      </div>
    </RouterLink>
    <div class="WorkCard_cover">
      <div class="HorizontalLayout --wrap">
        <div class="HorizontalLayout_col u-ma5" v-for="(skill, index) in work.skills" :key="index">
          <span
            class="Tag --link u-tip"
            data-desc="スキル分野で絞り込む"
            :style="bgColor(work.profession_type_id)"
            @click="$emit('onClickSkill', skill.id)"
          >{{ skill.body }}</span>
        </div>
      </div>
      <ul class="HorizontalLayout --stretch">
        <li class="HorizontalLayout_col --flex">
          <div class="WorkCard_text">
            <p class="WorkCard_title">{{ work.title }}</p>
            <p><ReplacedDate :datetime="work.created_at"></ReplacedDate></p>
          </div>
        </li>
        <li class="HorizontalLayout_col">
          <div class="WorkCard_professionType">
            <span class="Tag" :style="bgColor(work.profession_type_id)">{{ work.profession_type.body }}</span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
import { OK } from '@/util'
import styles from '@/mixins/styles'
import worksData from '@/mixins/worksData'
import ReplacedDate from '@/components/ReplacedDate'
export default {
  mixins: [styles, worksData],
  components: { ReplacedDate },
  computed: {
    favoriteStatus(){
      return this.work.is_favorite ? '「気になる」解除' : '「気になる」に登録する'
    },
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
