<template>
  <div>
    <input
      v-model="item.value"
      type="email"
      :name="item.name"
      class="Form_text"
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
