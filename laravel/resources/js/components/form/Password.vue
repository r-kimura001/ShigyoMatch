<template>
  <div>
    <input
      v-model="item.value"
      type="password"
      :name="item.name"
      class="Form_text --short"
      :class="setClass()"
      :placeholder="item.placeholder"
      :required="isRequired"
      :autofocus="isAutoFocus"
    />
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
}
</script>
