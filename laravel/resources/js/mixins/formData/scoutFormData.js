import styles from '@/mixins/styles'
export default {
  mixins: [styles],
  data(){
    return {
      formData: {
        title:{
          name: 'title',
          type: 'text',
          value: '',
          placeholder: 'タイトル(30文字まで)',
          classOption: {
            '--short': true,
          },
          options: {
            required: true,
            autofocus: true,
            maxLength: 30,
          },
        },
        work_id: {
          name: 'work_id',
          type: 'select',
          value: '',
          formLabel: {
            name: 'どの募集案件に対するスカウトか選んでください',
            style: this.bgImage('assets/icon-shop-gray.svg'),
          },
          classOption: {
            '--short': true,
          },
          options:{
            required: true
          },
          list: [],
          valueKey: 'id',
          labelKey: 'title',
        },
        body: {
          name: 'body',
          type: 'textarea',
          value: '',
          formLabel: {
            name: '案内文',
            style: this.bgImage('assets/icon-pen.svg'),
          },
          placeholder: '',
          rows: 15,
          classOption: {
            '--greeting': true,
          },
          options: {
            required: true,
            template: 'scoutMessage',
          }
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
