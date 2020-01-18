<template>
  <div>
    <div class="HorizontalLayout --justifyCenter">
      <div class="HorizontalLayout_col">
        <h3
          class="Tab --applier"
          :class="{'--show': currentFlag===applyFlag}"
          @click="onTabClick(applyFlag)"
        >
          <span class="Tab_text">応募側</span>
        </h3>
      </div>
      <div class="HorizontalLayout_col">
        <h3
          class="Tab --recruiter"
          :class="{'--show': currentFlag===recruitFlag}"
          @click="onTabClick(recruitFlag)"
        >
          <span class="Tab_text">募集側</span>
        </h3>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    props: {
      applyFlag: {
        type: Number,
        required: true,
        default: 0
      },
      recruitFlag: {
        type: Number,
        required: true,
        default: 1
      },
      currentFlag: {
        type: Number,
        required: true,
        default: 0
      },
    },
    methods: {
      onTabClick(flag){
        this.$emit('tabClick', flag)
      }
    }
  }
</script>
