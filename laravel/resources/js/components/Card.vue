<template>
  <div class="Card">
    <div class="Card_thumb">
      <div class="Card_overlay"></div>
      <div class="Card_decription">
        <div class="Card_moreLink">
          <RouterLink
            :to="`/customers/${customer.id}`"
            tag="button"
            class="BorderButton"
            >more</RouterLink
          >
        </div>
        <div class="Card_review">
          <p v-if="!hasReview" class="Text -nodata -fz14 u-alignCenter">レビューはありません</p>
          <Review v-else :score="averageReview"></Review>
        </div>
      </div>
      <!-- Card_review -->
      <div class="Card_thumbSrc" :style="bgImage(customer.file_name)"></div>
    </div>
    <div class="Card_summary">
      <h3 class="Card_name">{{ customer.name }}</h3>
      <ul class="Card_tags">
        <li
          v-for="(professionType, index) in professionTypes"
          :key="index"
          class="Card_tag"
        >
          <RouterLink
            tag="p"
            to="/customers"
            class="Tag"
            :style="bgColor(professionType.id)"
          >
            {{ professionType.body }}
          </RouterLink>
        </li>
      </ul>
      <div class="u-alignCenter">
        <ReplacedDate :datetime="customer.created_at"></ReplacedDate>
      </div>
    </div>
    <!-- Card_summary -->
  </div>
</template>
<script>
import styles from '@/mixins/styles'
import reviewCalc from '@/mixins/reviewCalc'
import Review from '@/components/Review'
import ReplacedDate from '@/components/ReplacedDate'
export default {
  components: {
    Review, ReplacedDate
  },
  mixins: [styles, reviewCalc],
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({
        name: 'name',
      }),
    },
    nameKey: {
      type: String,
      default: 'name',
    },
  },
  computed: {
    professionTypes() {
      return this.customer.profession_types
    },
  },
}
</script>
