<template>
  <div>
    <div class="Form_label" :class="setClass()" :style="item.formLabel.style">
      {{ item.formLabel.name }}
    </div>
    <div v-for="(professionType, index) in item.list" :key="index">
      <div class="Checkbox u-pl20">
        <input
          v-model="item.value"
          type="checkbox"
          :value="professionType[item.valueKey]"
          :data-label="professionType[item.labelKey]"
        />
      </div>
      <div class="Form_msgWrapper">
        <input
          v-model="item.registerNumbers[professionType.id]"
          :class="boxChecked(professionType.id)"
          type="text"
          class="Form_text --register-num --short"
          placeholder="登録番号"
        />
      </div>
    </div>
  </div>
</template>
<script>
import formOptions from '@/mixins/formOptions'
export default {
  mixins: [formOptions],
  methods: {
    boxChecked(id) {
      return {
        '--disable': this.item.value.indexOf(id) === -1,
      }
    },
  },
}
</script>
