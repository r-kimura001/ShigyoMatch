import styles from '@/mixins/styles'
import { OK } from '@/util'
export default {
  mixins: [styles],
  data(){
    return {
      formData: {
        login_id:{
          name: 'login_id',
          type: 'text',
          value: '',
          min: 6,
          max: 20,
          placeholder: 'ログインID(半角英数字6~20文字)',
          options: {
            required: true,
            autofocus: true,
            maxLength: 20,
          },
          classOption: {
            '--id': true,
          }
        },
        email:{
          name: 'email',
          type: 'email',
          value: '',
          placeholder: 'sample@example.com',
          options: {
            required: true,
          },
        },
        name: {
          name: 'name',
          type: 'text',
          value: '',
          placeholder: 'XXX法律事務所',
          options: {
            required: true,
          },
        },
        profession_types:{
          name: 'professionIds',
          type: 'professionTypes',
          value: [],
          list: [],
          valueKey: 'id',
          labelKey: 'body',
          registerNumbers: {},
          formLabel: {
            name: '資格',
            style: this.bgImage('assets/icon-license-card.svg'),
          },
          classOption: {
            'u-mb20': true,
          },

        },
        zip_code: {
          name: 'zip_code',
          type: 'number',
          value: '',
          placeholder: '0000000',
          classOption: {
            '--short': true,
          },
          options: {}
        },
        pref_code: {
          name: 'pref_code',
          type: 'select',
          value: '',
          formLabel: {
            name: '都道府県',
            style: this.bgImage('assets/icon-map.svg'),
          },
          classOption: {
            '--short': true,
            '--place': true,
          },
          list: [],
          valueKey: 'id',
          labelKey: 'name',
          options: {}
        },
        city: {
          name: 'city',
          type: 'text',
          value: '',
          placeholder: '市区町村',
          classOption: {
            '--place': true,
          },
          options: {}
        },
        address: {
          name: 'address',
          type: 'text',
          value: '',
          placeholder: '以降の所在場所',
          classOption: {
            '--place': true,
          },
          options: {}
        },
        building: {
          name: 'building',
          type: 'text',
          value: '',
          placeholder: 'ビル名',
          options: {}
        },
        file_name: {
          name: 'file_name',
          type: 'file',
          value: null,
          srcPath: '',
          deleteFlag: 0,
          formLabel: {
            name: 'プロフィール画像',
            style: this.bgImage('assets/icon-picture.svg')
          },
          options: {}
        },
        url: {
          name: 'url',
          type: 'url',
          value: '',
          placeholder: 'サイトURL',
          options: {}
        },
        greeting: {
          name: 'greeting',
          type: 'textarea',
          value: '',
          formLabel: {
            name: 'ひとこと',
            style: this.bgImage('assets/icon-pen.svg'),
          },
          placeholder: '140字以内',
          rows: 10,
          classOption: {
            '--greeting': true,
          },
          options: {
            maxLength: 140,
          }
        },
      },
    }
  },
  methods: {
    hasKey(key){
      return Object.keys(this.formData).indexOf(key) !== -1
    },
    async fetchPrefectures() {
      const response = await axios.get(`/api/prefectures`)
      if (response.status === OK) {
        this.formData.pref_code.list = response.data
      }
    },
  }
}
