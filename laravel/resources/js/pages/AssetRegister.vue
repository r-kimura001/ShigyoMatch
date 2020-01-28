<template>
  <div class="u-mt50">
    <form action="" @submit.prevent="upload">
      <input type="file" @change="onFileChange" />
      <output v-if="preview">
        <img :src="preview" alt="" />
      </output>
      <button type="submit">アップロード</button>
    </form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      preview: null,
      asset: null,
    }
  },
  computed: {},
  methods: {
    onFileChange(event) {
      if (event.target.files.length === 0) {
        return false
      }

      if (!event.target.files[0].type.match('image.*')) {
        return false
      }

      const reader = new FileReader()
      reader.onload = e => {
        this.preview = e.target.result
      }

      reader.readAsDataURL(event.target.files[0])

      this.asset = event.target.files[0]
    },
    reset() {
      this.preview = ''
      this.asset = null // ★ 追加
      this.$el.querySelector('input[type="file"]').value = null
    },
    async upload() {
      const formData = new FormData()
      formData.append('asset', this.asset)
      const response = await axios.post('/api/asset/register', formData)
      this.$store.commit('auth/setResponse', response)
      this.reset()
      this.$emit('input', false)
    },
  },
}
</script>
