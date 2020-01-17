<template>
  <div class="p-home">
    <div>
      <h2>Home</h2>
      <section class="MypageContent_box">
        <h3 class="">投稿中の募集案件</h3>
        <p v-if="!hasData">募集案件の投稿はありません</p>
        <WorkTableLayout
          v-else
          :works="works"
          @sendDelete="openDeleteModal"
        ></WorkTableLayout>
      </section>
    </div>
    <ConfirmModal :id="deleteId" @confirmed="deleteItem"></ConfirmModal>
  </div>
</template>
<script>
import { DELETED, UNPROCESSABLE_ENTITY, OK } from '@/util'
import WorkTableLayout from '@/layouts/WorkTableLayout'
import ConfirmModal from '@/components/modal/ConfirmModal'
export default {
  components: {
    WorkTableLayout,
    ConfirmModal,
  },
  props: {
    customer: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  data() {
    return {
      works: [],
      hasData: true,
      deleteId: null,
    }
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.worksByOwner()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async worksByOwner() {
      const response = await axios.get(
        `/api/customers/${this.customer.id}/works`
      )
      if (response.status !== OK) {
        this.hasData = false
      } else {
        this.works = response.data
        this.hasData = !!this.works.length
      }
    },
    openDeleteModal(id) {
      this.deleteId = id
      this.$store.commit('form/setConfirmModal', {
        isShow: true,
        exeText: '削除',
      })
    },
    async deleteItem(id) {
      this.$store.commit('form/setIsLoading', true)
      const response = await axios.delete(`/api/works/${id}`)
      this.deleteId = null
      if (response.status === DELETED) {
        await this.worksByOwner()
        this.$store.commit('form/setIsLoading', false)
        this.$store.commit('form/setDeleteMessage', '削除しました')
      } else if (response.status === UNPROCESSABLE_ENTITY) {
        this.$store.commit('error/setMessage', response.data.errors)
        this.$store.commit('form/setIsLoading', false)
      } else {
        this.$store.commit('error/setErrors', {
          message: response,
          status: response.status,
        })
        this.$store.commit('form/setIsLoading', false)
      }
    },
  },
}
</script>
