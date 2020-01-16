<template>
  <div class="Number">
    <div class="Number_form">
      <input
        v-model="item.value"
        type="number"
        :name="item.name"
        class="Form_text"
        :class="setClass()"
        :placeholder="item.placeholder"
        :required="isRequired()"
        :autofocus="isAutoFocus()"
        :max="maxNumber()"
      />
      <div class="Number_button">
        <button
          v-if="item.name === 'zip_code'"
          type="button"
          class="Button --minimum --hasShadow --pink"
          @click="setAddress"
        >
          住所検索
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
  methods: {
    setAddress() {
      let _this = this
      new YubinBango.Core(_this.item.value, function(addr) {
        _this.$store.commit('form/setAddress', addr)
      })
    },
  },
}
</script>
