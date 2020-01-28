<template>
  <footer class="Footer">
    <div class="Footer_content">
      <p class="Footer_text">
        &copy; Kaba {{ createdYear }}{{ currentYear() }} All Rights Reserved.
      </p>
    </div>
  </footer>
</template>

<script>
export default {
  data() {
    return {
      createdYear: 2019,
    }
  },
  methods: {
    currentYear() {
      const now = new Date().getFullYear()
      return this.createdYear < now ? `-${now}` : ''
    },
  },
}
</script>
