<template>
  <main class="p-top">
    <div class="MainLayout">
      <RouterLink to="/asset/register" tag="div" class="stick"></RouterLink>
    </div>
  </main>
</template>
<script>
import switchDisplay from '@/mixins/switchDisplay'
export default {
  mixins: [switchDisplay],
  methods: {},
}
</script>
