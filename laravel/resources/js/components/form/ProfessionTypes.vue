<template>
  <div>
    <div class="Form_label" :class="setClass()" :style="item.formLabel.style">
      {{ item.formLabel.name }}
      <RequiredMark></RequiredMark>
    </div>
    <div v-for="(professionType, index) in item.list" :key="index">
      <div class="Checkbox u-pl20">
        <input
          v-model="item.value"
          :name="item.name"
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
import RequiredMark from '@/components/form/RequiredMark'
export default {
  mixins: [formOptions],
  components: {
    RequiredMark
  },
  methods: {
    boxChecked(id) {
      return {
        '--disable': this.item.value.indexOf(id) === -1,
      }
    },
  },
}
</script>
