<template>
  <div>
    <div class="Form_label" :class="setClass()" :style="item.formLabel.style">
      {{ item.formLabel.name }}
    </div>
    <textarea
      v-model="item.value"
      :name="item.name"
      :rows="item.rows"
      class="Form_textarea"
      :placeholder="item.placeholder"
      :required="isRequired()"
      :autofocus="isAutoFocus()"
    ></textarea>
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
}
</script>
