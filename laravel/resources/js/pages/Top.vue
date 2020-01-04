<template>
  <div class="p-top">
    <h1 class="SiteTitle">士業のマッチングサイトです</h1>
    <div>
      <img
        src="https://asset.shigyo-match.site/assets/0h0IyXKhWjb2ZEIUVE5ZMQMQt8aQk9QnVuLll4XDF3ZUgxTXhmLFt2UD9-eQY2FCgzZDdjSWghUSkfQy9MMRBIcB8lahQdWFAxECFVcDtgdzEyDSg0fU4hBmAhMVFpGXpifkUiRWApOFY8E300.jpeg"
        alt=""
        @click="register"
      />
    </div>
    <RouterLink to="/asset/register" tag="div" class="stick"></RouterLink>
  </div>
</template>
<script>
export default {
  data() {
    return {
      registerForm: {
        login_id: '0123456',
        customer_id: 10,
        email: 'sample@example.com',
        password: 'test1234',
      },
    }
  },
  methods: {
    async register() {
      await this.$store.dispatch('auth/register', this.registerForm)
    },
  },
}
</script>
