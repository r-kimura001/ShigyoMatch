<template>
  <div class="WorkCard" :data-fee="work.fee.toLocaleString()">
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
}
</script>
