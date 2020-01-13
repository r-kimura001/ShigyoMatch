<template>
  <div>
    <div class="Form_label" :class="setClass()" :style="item.formLabel.style">
      {{ item.formLabel.name }}
    </div>
    <output v-if="previewUrl" class="Form_thumb u-mt20">
      <img :src="previewUrl" alt="" />
    </output>
    <div class="HorizontalLayout u-mt20">
      <div class="HorizontalLayou_col">
        <button
          type="button"
          class="Button --small --pink"
          @click="selectFile()"
        >
          画像を選択
        </button>
      </div>
      <div v-if="previewUrl" class="HorizontalLayout_col u-ml20">
        <button
          type="button"
          class="Button --small --secondary"
          @click="clear()"
        >
          クリア
        </button>
      </div>
    </div>
    <input
      type="file"
      :name="item.name"
      class="Form_file"
      :class="setClass()"
      :required="isRequired()"
      :autofocus="isAutoFocus()"
      @change="onFileChange"
    />
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
import { mapState } from 'vuex'
export default {
  mixins: [formOptions],
  data() {
    return {
      preview: null,
    }
  },
  computed: {
    ...mapState({
      deleteReview: state => state.form.deleteReview,
    }),
    previewUrl() {
      if (this.preview) {
        return this.preview
      } else if (this.item.srcPath) {
        return this.item.srcPath
      } else {
        return null
      }
    },
  },
  watch: {
    deleteReview: {
      async handler(val) {
        if (val) {
          await this.reset()
          this.$store.commit('form/setDeleteReview', false)
        }
      },
      immediate: true,
    },
  },
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

      this.item.value = event.target.files[0]
      this.item.deleteFlag = 0
    },
    selectFile() {
      this.$el.querySelector('.Form_file').click()
    },
    reset() {
      this.preview = ''
      this.item.value = ''
      this.item.srcPath = ''
      this.$el.querySelector('.Form_file').value = null
    },
    clear() {
      this.reset()
      this.item.deleteFlag = 1
    },
    async upload() {
      const formData = new FormData()
      formData.append('asset', this.item.value)
      const response = await axios.post('/api/asset/register', formData)
      this.$store.commit('auth/setResponse', response)
      this.reset()
      this.$emit('input', false)
    },
  },
}
</script>
