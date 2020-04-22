<template>
  <div class="p-works">
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <h2 class="BaseTitle --vertical">
            <span class="BaseTitle_text">
              パスワード再設定のお手続
            </span>
          </h2>
          <p v-if="showSuccessAlert">再設定用のURLをメール送信いたしました。</p>
          <FormLayout
            :form-data="formData"
            :submit-button-data="submitButtonData"
            @send="sendPasswordEmail"
          ></FormLayout>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
  import FormLayout from '@/layouts/FormLayout'
  export default {
    components: { FormLayout },
    data() {
      return {
        formData: {
          email: {
            type: 'email',
            name: 'email',
            value: '',
            placeholder: 'sample@example.com',
            options: {
              required: true,
            },
          },
        },
        submitButtonData: {
          text: '送信',
        },
        showSuccessAlert: false
      }
    },
    methods: {
      async SendPasswordEmail(){
        this.$store.commit('form/setIsLoading', true)
        // パスワードリセットのメール送信APIを実行する
        await axios.post('/api/password/email', this.form)
          .then(data => {
            this.$store.commit('form/setIsLoading', false)
            // 送信完了メッセージ表示
            this.showSuccessAlert = true

          })
          .catch(err=> {
            this.$store.commit('form/setIsLoading', false)
            console.log(err);
          });
      }
    }

  }
</script>
