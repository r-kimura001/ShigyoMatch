<template>
  <div class="ProfileFormLayout">
    <h2 class="ProfileFormLayout_title">プロフィール編集</h2>
    <div class="ProfileFormLayout_body">
      <FormLayout
        :form-data="formData"
        :error-messages="errorMessages"
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
    errorMessages: {
      type: Object,
      require: true,
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
