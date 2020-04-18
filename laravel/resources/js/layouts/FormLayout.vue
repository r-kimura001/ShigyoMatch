<template>
  <div class="Form">
    <form @submit.prevent="$emit('send')">
      <div v-for="(formItem, index) in FormData" :key="index" class="Form_row">
        <div class="Form_errorBox">
          <ErrorMessage
            v-if="hasError(formItem.name)"
            :error-message="errorMessages[formItem.name]"
          ></ErrorMessage>
        </div>
        <RequiredMark v-if="isRequired(formItem)"></RequiredMark>
        <Textbox v-if="formItem.type === 'text'" :item="formItem"></Textbox>
        <Number v-if="formItem.type === 'number'" :item="formItem"></Number>
        <Password
          v-if="formItem.type === 'password'"
          :item="formItem"
        ></Password>
        <Url v-if="formItem.type === 'url'" :item="formItem"></Url>
        <Email v-if="formItem.type === 'email'" :item="formItem"></Email>
        <Checkbox
          v-if="formItem.type === 'checkbox'"
          :item="formItem"
        ></Checkbox>
        <Radio v-if="formItem.type === 'radio'" :item="formItem" @onCheck="sendRadioData"></Radio>
        <Selectbox
          v-if="formItem.type === 'select'"
          :item="formItem"
        ></Selectbox>
        <TextareaBox
          v-if="formItem.type === 'textarea'"
          :item="formItem"
        ></TextareaBox>
        <Filebox v-if="formItem.type === 'file'" :item="formItem"></Filebox>
        <ProfessionTypes
          v-if="formItem.type === 'professionTypes'"
          :item="formItem"
        ></ProfessionTypes>
        <ReviewForm
          v-if="formItem.type === 'review'"
          :item="formItem"
        ></ReviewForm>
      </div>
      <div class="Form_row u-alignCenter">
        <button
          class="Form_button"
          :class="submitButtonData.class"
          @click="$emit('submit')"
        >
          {{ submitButtonData.text }}
        </button>
      </div>
    </form>
  </div>
</template>
<script>
import ErrorMessage from '@/components/form/ErrorMessage'
import RequiredMark from '@/components/form/RequiredMark'
import Textbox from '@/components/form/Textbox'
import Number from '@/components/form/Number'
import Password from '@/components/form/Password'
import Email from '@/components/form/Email'
import Checkbox from '@/components/form/Checkbox'
import Radio from '@/components/form/Radio'
import Selectbox from '@/components/form/Selectbox'
import TextareaBox from '@/components/form/TextareaBox'
import Url from '@/components/form/Url'
import Filebox from '@/components/form/Filebox'
import ProfessionTypes from '@/components/form/ProfessionTypes'
import ReviewForm from '@/components/form/ReviewForm'
import { mapGetters } from 'vuex'
export default {
  components: {
    ErrorMessage,
    RequiredMark,
    Textbox,
    Number,
    Password,
    Email,
    Checkbox,
    Radio,
    Selectbox,
    TextareaBox,
    Url,
    Filebox,
    ProfessionTypes,
    ReviewForm,
  },
  props: {
    FormData: {
      type: Object,
      required: true,
      default: () => ({}),
    },
    submitButtonData: {
      type: Object,
      required: true,
      default: () => ({
        text: 'submit',
        class: {},
      }),
    },
  },
  data(){
    return {
      val: null
    }
  },
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
    isRequired(formItem) {
      return 'options' in formItem && 'required' in formItem.options && formItem.options.required
    },
    sendRadioData(id){
      this.$emit('onRadioCheck', id)
    }
  },
}
</script>
