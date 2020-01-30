<template>
  <div class="WorkListLayout">
    <div
      v-for="(work, index) in works"
      :key="index"
      class="WorkListLayout_item"
    >
      <WorkCard
        :work="work"
        @onClickSkill="sendSkillId"></WorkCard>
    </div>
  </div>
</template>
<script>
import WorkCard from '@/components/WorkCard'
export default {
  components: { WorkCard },
  props: {
    works: {
      type: Array,
      required: true,
      default: () => [],
    },
    hasData: {
      type: Boolean,
      default: true
    }
  },
  methods: {
    sendSkillId(id){
      this.$emit('sendSkillId', id)
    }
  }
}
</script>
