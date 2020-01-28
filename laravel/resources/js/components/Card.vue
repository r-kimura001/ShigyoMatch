<template>
  <div class="Card">
    <div class="Card_thumb">
      <div class="Card_overlay"></div>
      <div class="Card_decription">
        <div class="Card_moreLink">
          <RouterLink
            :to="`/customers/${item.id}`"
            tag="button"
            class="BorderButton"
            >more</RouterLink
          >
        </div>
        <div class="Card_review">
          <Review :score="Number(3.5)"></Review>
        </div>
      </div>
      <!-- Card_review -->
      <div class="Card_thumbSrc" :style="bgImage(item.file_name)"></div>
    </div>
    <div class="Card_summary">
      <h3 class="Card_name">{{ item.name }}</h3>
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
    </div>
    <!-- Card_summary -->
  </div>
</template>
<script>
import styles from '@/mixins/styles'
import Review from '@/components/Review'
import { dateReplace } from '@/util'
export default {
  components: {
    Review,
  },
  mixins: [styles],
  props: {
    item: {
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
      return this.item.profession_types
    },
    date(){
      return dateReplace(this.item.created_at)
    }
  },
}
</script>
