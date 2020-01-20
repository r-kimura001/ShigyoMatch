<template>
  <div class="Modal --confirm" :class="{ '--hidden': !isShow }">
    <div class="Modal_overlay"></div>
    <div class="Modal_content">
      <div>
        <div class="Form">
          <form @submit.prevent="$emit('send')">
            <div class="Form_row">
              <div class="Form_errorBox">
                <ErrorMessage
                  v-if="hasError(formItem.name)"
                  :error-message="errorMessages[formItem.name]"
                ></ErrorMessage>
              </div>
              <TextareaBox
                :item="formItem"
              ></TextareaBox>
            </div>
            <div class="Modal_buttons u-alignCenter u-mt20">
              <div class="Button --secondary" @click="close()">キャンセル</div>
              <button class="Button --pink" @click="$emit('submit')">
                送信
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import ErrorMessage from '@/components/form/ErrorMessage'
  import TextareaBox from '@/components/form/TextareaBox'
  import styles from '@/mixins/styles'
  import { mapGetters } from 'vuex'
  export default {
    props: {
      isShow: {
        type: Boolean,
        default: false
      },
      formItem: {
        type: Object,
        required: true,
        default: () => ({})
      }
    },
    mixins: [styles],
    components: { ErrorMessage, TextareaBox },
    computed: {
      ...mapGetters({
        errorMessages: 'error/message',
      }),
    },
    methods: {
      hasError(prop) {
        return (
          this.errorMessages !== null &&
          Object.keys(this.errorMessages).indexOf(prop) >= -1
        )
      },
      close() {
        this.$emit('onClickClose')
      },
    },
  }
</script>
