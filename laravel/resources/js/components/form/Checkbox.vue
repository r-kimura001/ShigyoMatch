<template>
  <div>
    <div class="Form_label" :style="item.formLabel.style">
      {{ item.formLabel.name }}
    </div>
    <p v-if="!item.list.length" class="Form_note">業務分野を選択すると関連タグが表示されます</p>
    <ul v-else class="HorizontalLayout --wrap">
      <li class="HorizontalLayout_col u-ma5" v-for="(boxData, index) in item.list" :key="index">
        <div class="Checkbox" :class="setClass()">
          <input
            type="checkbox"
            :id="`data_${boxData[item.valueKey]}`"
            :name="item.name"
            v-model="item.value"
            :value="boxData[item.valueKey]"
          >
          <label :for="`data_${boxData[item.valueKey]}`" class="Checkbox_label">{{ boxData[item.labelKey] }}</label>
        </div>
      </li>
    </ul>
  </div>

</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
}
</script>
