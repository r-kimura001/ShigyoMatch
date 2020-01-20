<template>
  <div class="MainLayout">
    <h1 class="MainLayout_heading">お申し込みフォーム</h1>
    <div class="MainLayout_boxList">
      <section class="MainLayout_box">
        <RouterLink :to="`/works/${work.id}`" tag="button" class="Button --minimum --secondary">募集内容に戻る</RouterLink>
        <div class="ApplyFormLayout">
          <h2 class="ApplyFormLayout_title">
            <span class="ApplyFormLayout_titleText">プロフィール内容をご確認ください</span>
          </h2>
          <div class="u-alignRight">
            <RouterLink :to="`/mypage/${customer.id}/profile`" tag="button" class="Button --small">修正する</RouterLink>
          </div>
          <div class="ApplyFormLayout_info">
            <ul class="ApplyFormLayout_infoList">
              <li class="ApplyFormLayout_infoItem">
                <dl class="DefinitionLayout">
                  <dt class="DefinitionLayout_term">事務所名</dt>
                  <dd class="DefinitionLayout_desc">{{ customer.name }}</dd>
                </dl>
              </li>
              <li class="ApplyFormLayout_infoItem">
                <dl class="DefinitionLayout">
                  <dt class="DefinitionLayout_term">メールアドレス</dt>
                  <dd class="DefinitionLayout_desc">{{ customer.user.email }}</dd>
                </dl>
              </li>
              <li class="ApplyFormLayout_infoItem">
                <dl class="DefinitionLayout">
                  <dt class="DefinitionLayout_term">資格</dt>
                  <dd class="DefinitionLayout_desc" v-for="(item, index) in customer.profession_types" :key="index">{{ item.body }}</dd>
                </dl>
              </li>
              <li class="ApplyFormLayout_infoItem">
                <dl class="DefinitionLayout">
                  <dt class="DefinitionLayout_term">所在場所</dt>
                  <dd class="DefinitionLayout_desc">{{ customer.full_address }}</dd>
                </dl>
              </li>
              <li class="ApplyFormLayout_infoItem">
                <dl class="DefinitionLayout">
                  <dt class="DefinitionLayout_term">URL</dt>
                  <dd class="DefinitionLayout_desc">{{ customer.url }}</dd>
                </dl>
              </li>
              <li class="ApplyFormLayout_infoItem">
                <dl class="DefinitionLayout">
                  <dt class="DefinitionLayout_term">プロフィール画像</dt>
                  <dd class="DefinitionLayout_desc">
                    <img :src="thumbSrc(customer.file_name)" alt="">
                  </dd>
                </dl>
              </li>
              <li class="ApplyFormLayout_infoItem">
                <dl class="DefinitionLayout">
                  <dt class="DefinitionLayout_term">ひとこと</dt>
                  <dd class="DefinitionLayout_desc">{{ customer.greeting }}</dd>
                </dl>
              </li>
            </ul>
          </div>
          <h2 class="ApplyFormLayout_title">
            <span class="ApplyFormLayout_titleText">プロフィールに問題なければ自己PRを入力してください</span>
          </h2>
          <FormLayout
            :form-data="formData"
            :submit-button-data="submitButtonData"
            @send="apply"
          ></FormLayout>
        </div>
      </section>
    </div>
  </div>
</template>
<script>
  import FormLayout from '@/layouts/FormLayout'
  import applyFormData from '@/mixins/formData/applyFormData'
  import { CREATED, UNPROCESSABLE_ENTITY } from "@/util"
  import { mapState } from "vuex"
  export default {
    props:{
      work: {
        type: Object,
        required: true,
        default: () => ({}),
      }
    },
    data(){
      return {
        labels: {
          name: '事務所名',
          user: 'メールアドレス',
          profession_types: '資格',
          full_address: '所在場所',
          url: 'URL',
          file_name: 'プロフィール画像',
          greeting: '一言',
        },
        submitButtonData: {
          text: '上記の内容で申し込む',
          class: {
            '--radius': true,
            '--blue': true
          },
        },
      }
    },
    components: { FormLayout },
    mixins: [ applyFormData ],
    computed: {
      ...mapState({
        customer: state => state.auth.customer
      })
    },
    methods: {
      async apply() {
        if(!confirm('一度申し込むと取り消しができません。申込をしてよろしいですか？')){
          return false
        }
        this.$store.commit('form/setIsLoading', true)

        const applyData = new FormData()
        const keys = Object.keys(this.formData).filter(
          key => !!this.formData[key].value
        )
        keys.forEach(key => {
          applyData.append(key, this.formData[key].value)
        })
        applyData.append('applier_id', this.customer.id)

        const response = await axios.post(`/api/works/${this.work.id}/apply`, applyData)

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
          this.$store.commit('form/setSuccessMessage', '申込が完了しました')
          this.$router.push(`/mypage/${this.customer.id}/applies`)
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
