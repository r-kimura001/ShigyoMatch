<template>
  <div class="ApplyDetail" :class="{'--show': hasData}">
    <div class="ApplyDetail_content" v-if="hasData">
      <div class="ApplyFormLayout">
        <h2 class="ApplyFormLayout_title">
          <span class="ApplyFormLayout_titleText">スカウトの内容</span>
        </h2>
        <div class="ApplyFormLayout_info">
          <ul class="ApplyFormLayout_infoList">
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">タイトル</dt>
                <dd class="DefinitionLayout_desc">{{ scout.title }}</dd>
              </dl>
            </li>
            <li class="ApplyFormLayout_infoItem">
              <dl class="DefinitionLayout">
                <dt class="DefinitionLayout_term">内容</dt>
                <dd class="DefinitionLayout_desc">{{ scout.body }}</dd>
              </dl>
            </li>
          </ul>
        </div>
      </div>
      <!-- ApplyFormLayout -->
    </div>
    <!-- ApplyDetail_content -->
    <button class="ApplyDetail_close" @click="out"></button>
  </div>
</template>
<script>
  export default {
    props: ['scout'],
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
        return !!this.scout
      },
    },
    methods: {
      out(){
        this.$emit('onClickOut')
      },
    }
  }
</script>
