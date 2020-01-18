<template>
  <!-- selectbox -->
  <div>
    <div class="Form_label" :style="item.formLabel.style">
      {{ item.formLabel.name }}
    </div>
    <select
      v-model="item.value"
      :name="item.name"
      class="Selectbox"
      :class="setClass()"
      :required="isRequired"
      :autofocus="isAutoFocus"
    >
      <option
        v-for="(listItem, idx) in item.list"
        :key="idx"
        :value="listItem[item.valueKey]"
        >{{ listItem[item.labelKey] }}</option
      >
    </select>
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
}
</script>
