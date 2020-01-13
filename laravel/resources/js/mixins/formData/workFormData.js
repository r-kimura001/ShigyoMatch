import styles from '@/mixins/styles'
import { BASE_STORAGE_URL } from '@/util'
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
          options: {
            required: true,
            autofocus: true,
            maxLength: 30,
          },
        },
        fee:{
          name: 'fee',
          type: 'number',
          value: '',
          placeholder: '報酬（999,999円まで）',
          classOption: {
            '--short': true,
          },
          options: {
            maxNumber: 999999,
            required: true
          }
        },
        profession_type_id: {
          name: 'profession_type_id',
          type: 'radio',
          value: '',
          formLabel: {
            name: '業務分野',
            style: this.bgImage('assets/icon-license-card.svg'),
          },
          classOption: {
            '--short': true,
          },
          list: [],
          valueKey: 'id',
          labelKey: 'body',
          options: {}
        },
        file_name: {
          name: 'file_name',
          type: 'file',
          value: null,
          srcPath: '',
          deleteFlag: 0,
          formLabel: {
            name: 'サムネイル画像',
            style: this.bgImage('assets/icon-picture.svg')
          },
        },
        body: {
          name: 'body',
          type: 'textarea',
          value: '',
          formLabel: {
            name: '募集要項',
            style: this.bgImage('assets/icon-pen.svg'),
          },
          placeholder: '募集要項を入力してください',
          rows: 10,
          classOption: {
            '--greeting': true,
          },
        },
      },
    }
  },
  methods: {
    hasKey(key){
      return Object.keys(this.formData).indexOf(key) !== -1
    },
    clearFormValue(){
      Object.keys(this.formData).forEach( key => {
        this.formData[key].value = ''
      })
      this.formData.file_name.deleteFlag = 0
    }
  }
}
