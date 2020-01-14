<template>
  <div>
    <div class="ResultMessage" :class="{ '--hidden': !message }">
      <p class="ResultMessage_text">{{ message }}</p>
    </div>
    <div class="ResultMessage --delete" :class="{ '--hidden': !deleteMessage }">
      <p class="ResultMessage_text">{{ deleteMessage }}</p>
    </div>
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
          }, 3000)
        }
      },
      immediate: true,
    },
    deleteMessage: {
      async handler(val) {
        if (val) {
          setTimeout(() => {
            this.$store.commit('form/setDeleteMessage', null)
          }, 3000)
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
      deleteMessage: 'form/deleteMessage',
    }),
  },
}
</script>
