<template>
  <div class="Modal --confirm" :class="{ '--hidden': !modalData.isShow }">
    <div class="Modal_overlay"></div>
    <div class="Modal_content">
      <div>一度削除すると元に戻せません。削除しますか？</div>
      <div class="Modal_buttons u-alignCenter u-mt20">
        <div class="Button --secondary" @click="close()">キャンセル</div>
        <div class="Button --danger" @click="confirmed()">
          {{ modalData.exeText }}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  props: {
    id: {
      type: Number,
    },
  },
  computed: {
    ...mapGetters({
      modalData: 'form/confirmModal',
    }),
  },
  methods: {
    close() {
      this.$store.commit('form/setConfirmModal', {
        isShow: false,
        exeText: null,
      })
    },
    confirmed() {
      this.close()
      this.$emit('confirmed', this.id)
    },
  },
}
</script>
