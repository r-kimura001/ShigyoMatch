import styles from '@/mixins/styles'
export default {
  mixins: [styles],
  data(){
    return {
      formData: {
        point:{
          name: 'point',
          type: 'review',
          value: 5,
        },
        comment: {
          name: 'comment',
          type: 'textarea',
          value: '',
          formLabel: {
            name: 'レビュー本文',
            style: this.bgImage('assets/icon-pen.svg'),
          },
          placeholder: '誹謗、中傷、その他規約に反すると判断した場合、削除させていただくことがあります。',
          rows: 5,
          classOption: {
            '--greeting': true,
          },
          options: {
            required: true,
          }
        },
      },
    }
  },
  methods: {
    clearFormValue(){
      this.formData.comment.value = ''
      this.formData.point.value = 5
    },
  }
}
