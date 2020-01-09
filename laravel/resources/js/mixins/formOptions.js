import { mapGetters } from 'vuex'
export default {
  props: {
    item: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  methods: {
    isRequired() {
      return 'options' in this.item && 'required' in this.item.options
    },
    isAutoFocus() {
      return 'options' in this.item && 'required' in this.item.options
    },
    setClass() {
      return Object.keys(this.item).indexOf('classOption') !== -1
        ? this.item.classOption
        : ''
    },
  },
  computed: {
    ...mapGetters({
      addrObj: 'form/address'
    })
  },
  watch: {
    // 住所検索ボタンを押したときの挙動
    addrObj(addr) {
      if(addr === null){
        return false
      }else if(this.item.name === 'pref_code'){
        this.item.value = addr.region_id
      }else if(this.item.name === 'city'){
        this.item.value = addr.locality
      }else if(this.item.name === 'address'){
        this.item.value = addr.street
      }
    },
  },



}
