<template>
  <div>
    <div class="HorizontalLayout --vertical">
      <div class="HorizontalLayout_col --flex">
        <label :for="item.name" class="Form_label" :class="setClass()" :style="item.formLabel.style">
          {{ item.formLabel.name }}
        </label>
      </div>
      <div class="HorizontalLayout_col">
        <button type="button" class="BorderButton --minimum" v-if="hasTemplate" @click="setTemplate()">テンプレートを適用する</button>
      </div>
    </div>
    <textarea
      :id="item.name"
      v-model="item.value"
      :name="item.name"
      :rows="item.rows"
      class="Form_textarea"
      :placeholder="item.placeholder"
      :required="isRequired"
      :autofocus="isAutoFocus"
    ></textarea>
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
}
</script>
