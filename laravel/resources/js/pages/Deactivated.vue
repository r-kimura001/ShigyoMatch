<template>
  <div class="p-deactivated">
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <h2 class="">
            <span>退会が完了しました。またのご利用をお待ちしております。<br>数秒後に画面が切り替わります。</span>
          </h2>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    watch: {
      $route: {
        handler(){
          setTimeout( () => {
            this.$router.push('/')
          }, 3000)
        },
        immediate: true
      }
    }
  }
</script>
