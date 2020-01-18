<template>
  <div>
    <div class="Form_label" :style="item.formLabel.style">
      {{ item.formLabel.name }}
    </div>
    <div class="HorizontalLayout">
      <div
        v-for="(listItem, idx) in item.list"
        :key="idx"
        class="HorizontalLayout_col u-pa10"
      >
        <input
          :id="`profession_type_${listItem[item.valueKey]}`"
          v-model="item.value"
          :name="item.name"
          type="radio"
          class="Radio"
          :value="listItem[item.valueKey]"
          :required="isRequired"
          :data-label="listItem[item.labelKey]"
          @change="$emit('onCheck', item.value)"
        /><label
          :for="`profession_type_${listItem[item.valueKey]}`"
          class="Radio_label"
          >{{ listItem[item.labelKey] }}</label
        >
      </div>
    </div>
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
}
</script>
