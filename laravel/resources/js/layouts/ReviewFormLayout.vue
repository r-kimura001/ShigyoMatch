<template>
  <div class="ReviewFormLayout">
    <div class="Modal" :class="{'--hidden': !isCurrent}">
      <div class="Modal_overlay"></div>
      <div class="Modal_content">
        <h4 class="Modal_heading">
          {{ reviewee.name }}さんへのレビュー
        </h4>
        <div class="Modal_body">
          <section class="MainLayout_box">
            <div class="ReviewFormLayout_workInfo">
              <h5 class="ReviewFormLayout_workHeading">
                <div class="HorizontalLayout --justifyCenter --vertical">
                  <div class="HorizontalLayout_col">
                    案件：{{ apply.work.title }}
                  </div>
                  <div class="HorizontalLayout_col u-ml10">
                    <button class="ReviewFormLayout_toggle" @click="open = !open" :class="{'--open': open}"></button>
                  </div>
                </div>
              </h5>
              <ul class="ReviewFormLayout_workMain" :class="{'--hidden': !open}">
                <li class="ReviewFormLayout_workItem">報酬：{{ `\¥${apply.work.fee.toLocaleString()}` }}</li>
                <li class="ReviewFormLayout_workItem">募集要項：{{ apply.work.body }}</li>
                <li class="ReviewFormLayout_workThumb">
                  <img :src="thumbSrc(apply.work.file_name)" alt="">
                </li>
              </ul>
            </div>
          </section>
          <section class="MainLayout_box u-mt10">
            <div class="ReviewFormLayout_form">
              <FormLayout
                :form-data="formData"
                :submit-button-data="submitButtonData"
                @send="review"
              ></FormLayout>
            </div>
          </section>
        </div>
        <div class="Modal_close">
          <button class="Button --close" @click="$emit('onClickClose')"></button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import FormLayout from '@/layouts/FormLayout'
  import reviewFormData from '@/mixins/formData/reviewFormData'
  import styles from '@/mixins/styles'
  import { CREATED, UNPROCESSABLE_ENTITY, OK } from "@/util"
  import { mapState } from "vuex"
  export default {
    components: { FormLayout },
    mixins: [ reviewFormData, styles ],
    props: {
      apply: {
        type: Object,
        required: true,
        default: () => ({})
      },
      reviewee: {
        type: Object,
        required: true,
        default: () => ({})
      },
      currentId: {
        type: Number,
        required: true,
        default: 0
      }
    },
    data(){
      return {
        submitButtonData: {
          text: 'レビューを投稿する',
          class: {
            '--radius': true,
            '--orange': true
          },
        },
        open: false,
        test: ''
      }
    },
    computed: {
      ...mapState({
        reviewer: state => state.auth.customer
      }),
      isCurrent(){
        return this.apply.id === this.currentId
      }
    },
    methods: {
      async review() {
        this.$store.commit('form/setIsLoading', true)

        const reviewData = new FormData()
        const keys = Object.keys(this.formData).filter(
          key => !!this.formData[key].value
        )
        keys.forEach(key => {
          reviewData.append(key, this.formData[key].value)
        })
        reviewData.append('apply_id', this.apply.id)
        reviewData.append('reviewee_id', this.reviewee.id)

        const response = await axios.post(`/api/customers/${this.reviewer.id}/reviews/store`, reviewData)
        this.$store.commit('form/setResponse', response)
        this.$store.commit('form/setIsLoading', false)

        if (response.status === UNPROCESSABLE_ENTITY) {
          this.$store.commit('error/setMessage', response.data.errors)
          this.$scrollTo('.Header', 1500)
          return false
        } else if (response.status === CREATED) {
          this.$store.commit('error/setErrors', {
            message: null,
            status: null,
          })
          this.clearFormValue()
          this.$store.commit('form/setSuccessMessage', 'レビューを投稿しました')
          this.$emit('onReviewed')
        } else {
          this.$store.commit('error/setErrors', {
            message: response,
            status: response.status,
          })
        }
      },
    }
  }
</script>
