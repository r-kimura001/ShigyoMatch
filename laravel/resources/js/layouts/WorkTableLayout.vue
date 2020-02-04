<template>
  <div class="WorkTableLayout">
    <BaseTable
      :list="works"
      :labels="labels"
      :operation="true"
      @onClickEdit="toEdit"
      @onClickDelete="sendDelete"
    ></BaseTable>
  </div>
</template>
<script>
import BaseTable from '@/components/Table'
export default {
  components: { BaseTable },
  props: {
    works: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
  data() {
    return {
      labels: [
        {
          key: 'title',
          name: 'タイトル',
          withIcon: 'file_name',
          link: {
            path: 'works',
            paramKey: 'id',
          },
        },
        {
          key: 'fee',
          name: '報酬',
        },
        {
          key: 'profession_type',
          key2: 'body',
          name: '資格',
          tag: {
            bgColorKey: 'id',
          },
        },
        {
          key: 'created_at',
          name: '投稿日時',
          isDate: true,
        },
      ],
      test: '',
    }
  },
  methods: {
    toEdit(id) {
      this.$router.push(`/works/${id}/edit`)
    },
    sendDelete(id) {
      this.$emit('sendDelete', id)
    },
  },
}
</script>
