<template>
  <div class="ResultMessage" :class="{ '--hidden': !message }">
    <p class="ResultMessage_text">{{ message }}</p>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  watch: {
    message: {
      async handler(val) {
        if (val) {
          setTimeout(() => {
            this.$store.commit('form/setSuccessMessage', null)
          }, 4000)
        }
      },
      immediate: true,
    },
  },
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
