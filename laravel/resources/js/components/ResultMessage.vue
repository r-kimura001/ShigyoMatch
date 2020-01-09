<template>
  <div class="ResultMessage" :class="{ '--hidden': !message }">
    <p class="ResultMessage_text">{{ message }}</p>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  methods: {
    hasMessage() {
      return !!this.message
    },
  },
  computed: {
    ...mapGetters({
      message: 'form/successMessage',
    }),
  },
}
</script>
