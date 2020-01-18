import { mapGetters } from 'vuex'
export default {
  props: {
    work: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  computed: {
    ...mapGetters({
      isLogin: 'auth/isLogin'
    }),
    canApply() {
      return this.isLogin && !this.work.is_owner && !this.work.is_applier
    },
    isApplied(){
      return this.work.is_applier
    },
    isScouted(){
      return this.work.is_scouted
    },
    showable(){
      return !this.work.is_owner
    }
  },
}
