<template>
  <div class="ApplyDetail" :class="{'--show': hasData}">
    <div class="ApplyDetail_content" v-if="hasData">
      <div class="ApplyFormLayout">
        <h2 class="ApplyFormLayout_title">
          <span class="ApplyFormLayout_titleText">{{ applier.name }}さんのプロフィール</span>
        </h2>
        <div class="ApplyFormLayout_info">
          <ul class="ApplyFormLayout_infoList">
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">事務所名</dt>
                <dd class="DefinitionLayout_desc">
                  <RouterLink
                    :to="`/customers/${applier.id}`"
                    tag="span"
                    class="Text -link">{{ applier.name }}</RouterLink>
                </dd>
              </dl>
            </li>
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">メールアドレス</dt>
                <dd class="DefinitionLayout_desc">{{ applier.user.email }}</dd>
              </dl>
            </li>
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">資格</dt>
                <dd class="DefinitionLayout_desc" v-for="(item, index) in applier.profession_types" :key="index">{{ item.body }}</dd>
              </dl>
            </li>
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">所在場所</dt>
                <dd class="DefinitionLayout_desc">{{ applier.full_address }}</dd>
              </dl>
            </li>
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">URL</dt>
                <dd class="DefinitionLayout_desc"><a :href="applier.url" class="Text -link">{{ applier.url }}</a></dd>
              </dl>
            </li>
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">プロフィール画像</dt>
                <dd class="DefinitionLayout_desc">
                  <img :src="thumbSrc(applier.file_name)" alt="">
                </dd>
              </dl>
            </li>
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">ひとこと</dt>
                <dd class="DefinitionLayout_desc">{{ applier.greeting }}</dd>
              </dl>
            </li>
          </ul>
        </div>
        <h2 class="ApplyFormLayout_title">
          <span class="ApplyFormLayout_titleText">{{ applier.name }}さんの自己PR</span>
        </h2>
        <div class="ApplyDetail_pr">{{ applier.pivot.pr }}</div>
      </div>
      <!-- ApplyFormLayout -->
      <button v-if="!isApplier" class="Button --fixed --pink" @click="isShow = true">メッセージを開始する</button>
    </div>
    <!-- ApplyDetail_content -->
    <button class="ApplyDetail_close" @click="out"></button>
    <MessageModal
      @send="storeMessage"
      @onClickClose="isShow = false"
      :isShow="isShow"
      :formItem="formItem"></MessageModal>
  </div>
</template>
<script>
  import { CREATED, UNPROCESSABLE_ENTITY } from "@/util";
  import styles from '@/mixins/styles'
  import MessageModal from '@/components/modal/MessageModal'
  export default {
    props: {
      applier: {
        type: Object,
        required: true,
        default: () => ({})
      }
    },
    components: { MessageModal },
    mixins: [styles],
    data(){
      return {
        isShow: false,
        formItem: {
          name: 'body',
          value: '',
          formLabel: {
            name: 'メッセージ',
            style: this.bgImage('assets/icon-mail.svg'),
          },
          placeholder: 'メッセージ本文',
          rows: 10,
        },
      }
    },
    computed: {
      hasData(){
        return !!Object.keys(this.applier).length
      },
      isApplier(){
        const author = this.$store.state.auth.customer
        return this.applier.id === author.id
      },
    },
    methods: {
      out(){
        this.$emit('onClickOut')
      },
      async storeMessage(){
        this.$store.commit('form/setIsLoading', true)
        const messageData = new FormData()
        messageData.append('body', this.formItem.value)
        messageData.append('apply_id', this.applier.pivot.id)
        messageData.append('sender_id', this.applier.work.customer.id)
        messageData.append('receiver_id', this.applier.id)

        const response = await axios.post('/api/messages/store', messageData)

        this.$store.commit('form/setIsLoading', false)

        if(response.status === CREATED){
          this.$store.commit('form/successMessage', 'メッセージを送信しました。')
          this.$emit('created')
        }else{
          this.$store.commit('error/setErrors', {
            status: response.status,
            message: response.data.errors,
          })
        }
      }
    }
  }
</script>
