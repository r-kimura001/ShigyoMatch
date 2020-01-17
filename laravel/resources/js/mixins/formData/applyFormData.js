import styles from '@/mixins/styles'
export default {
  mixins: [styles],
  data(){
    return {
      formData: {
        pr:{
          name: 'pr',
          type: 'textarea',
          value: '',
          formLabel: {
            name: '自己PR',
            style: this.bgImage('assets/icon-pen.svg'),
          },
          placeholder: '業務経験、実績、長所など',
          rows: 10,
          classOption: {
            '--greeting': true,
          },
        },
      },
    }
  },
  methods: {
    clearFormValue(){
      Object.keys(this.formData).forEach( key => {
        this.formData[key].value = ''
      })
    },
  }
}
