<template>
  <div class="ProfileFormLayout">
    <div class="ProfileFormLayout_body">
      <FormLayout
        :form-data="formData"
        :submit-button-data="submitButtonData"
        @send="$emit('profileSubmit')"
      ></FormLayout>
    </div>
  </div>
</template>
<script>
import FormLayout from '@/layouts/FormLayout'
export default {
  components: { FormLayout },
  props: {
    formData: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  data() {
    return {
      submitButtonData: {
        text: '保存',
        class: {
          '--radius': true,
        },
      },
      test: null,
    }
  },
}
</script>
