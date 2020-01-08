<template>
  <div>
    <input
      v-model="data.value"
      type="number"
      :name="data.name"
      class="Form_text"
      :class="setClass()"
      :placeholder="data.placeholder"
      :required="isRequired()"
      :autofocus="isAutoFocus()"
    />
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
}
</script>
