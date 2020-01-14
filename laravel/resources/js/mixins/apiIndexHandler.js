import { OK } from '@/util'
import Pager from '@/components/Pager'
export default {
  components: { Pager },
  props: {
    page: {
      type: Number,
    },
    paramPath: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      list: [],
      from: null,
      to: null,
      currentPage: null,
      lastPage: null,
      hasData: true,
    }
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.index()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async index() {
      const response = await axios.get(`/api/${this.paramPath}`, {
        params: {
          page: this.page,
        },
      })
      this.$store.commit('error/setStatus', response.status)
      this.$store.commit('error/setMessage', response)
      this.list = response.data.data
      this.from = response.data.from
      this.to = response.data.to
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
      this.hasData = !!this.list.length
    },
  },
}
