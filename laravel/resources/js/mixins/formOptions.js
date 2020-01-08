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
}
