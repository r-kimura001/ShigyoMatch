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
      return 'options' in this.item && 'autofocus' in this.item.options
    },
    setClass() {
      return 'classOption' in this.item !== -1
        ? this.item.classOption
        : ''
    },
    maxLength(){
      if( 'options' in this.item && 'maxLength' in this.item.options ){
        return this.item.options.maxLength
      }
    },
    maxNumber(){
      if( 'options' in this.item && 'maxNumber' in this.item.options ){
        return this.item.options.maxNumber
      }
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
