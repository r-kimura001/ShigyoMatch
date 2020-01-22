<template>
  <div>
    <button class="Button --minimum" @click="scout">
      スカウト
    </button>
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
    }
  },
  methods: {
    scout(){
      if(!this.author){
        alert('スカウト機能をご利用になるにはログインしてください')
        return false
      }
      this.$router.push(`/customers/${this.id}/scout`)
    }
  }
}
</script>
