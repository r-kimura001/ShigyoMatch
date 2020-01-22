<template>
  <div class="Review">
    <p class="Review_rating">
      <span class="Review_ratingFront" :style="frontStyle()">★★★★★</span>
      <span class="Review_ratingBack">★★★★★</span>
    </p>
    <span class="Review_score">{{ score }}</span>
  </div>
</template>
<script>
export default {
  props: {
    score: {
      type: Number,
      default: 1,
    },
  },
  data() {
    return {
      maxScore: 5,
    }
  },
  computed: {
    frontWidth() {
      return Math.ceil((this.score / this.maxScore) * 100)
    },
  },
  methods: {
    frontStyle() {
      return {
        width: `${this.frontWidth}%`,
      }
    },
  },
}
</script>
