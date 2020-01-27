<template>
  <div>
    <button
      class="BorderButton --minimum --blue"
      @click="onFollowClick"
      :class="{ '--followed': isFollow }"
    >{{ txt }}</button>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: Number,
      required: true,
    },
    author:{
      required: true,
      default: () => ({})
    },
    followers:{
      type: Array,
      default: () => ([])
    },
    isFollow: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    txt(){
      return this.isFollow ? 'フォロー済み' : 'フォロー'
    },
  },
  methods: {
    onFollowClick(){
      if(!this.author){
        alert('フォロー機能をご利用になるにはログインしてください')
        return false
      }
      this.$emit('followClick')
    },
  }
}
</script>
