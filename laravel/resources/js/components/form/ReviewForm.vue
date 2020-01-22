<template>
  <div class="ReviewForm">
    <Review :score="item.value"></Review>
    <div class="ReviewForm_button --remove">
      <div class="Button --review" @click="remove">-</div>
    </div>
    <div class="ReviewForm_button --add">
      <div class="Button --review" @click="add">+</div>
    </div>
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
import Review from '@/components/Review'
export default {
  mixins: [formOptions],
  components: {
    Review
  },
  data() {
    return {
      maxScore: 5,
      minScore: 1,
    }
  },
  methods: {
    add(){
      if(this.item.value === this.maxScore){
        this.item.value = this.maxScore
      }else{
        this.item.value++
      }
    },
    remove(){
      if(this.item.value === this.minScore){
        this.item.value = this.minScore
      }else{
        this.item.value--
      }
    },
  },
}
</script>
