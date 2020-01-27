import { OK, PER_PAGE } from '@/util'
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
    },
    skill: {
      type: String,
      default: '弁護士'
    },
  },
  data() {
    return {
      list: [],
      from: null,
      to: null,
      currentPage: null,
      lastPage: null,
      hasData: true,
      professionId: 1
    }
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.getProfessionId()
        await this.index()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async getProfessionId(){
      const response = await axios.get(`/api/professionId`, {
        params: {
          body: this.skill
        },
      })
      this.professionId = response.data.id
    },
    async index() {
      const response = await axios.get(`/api/${this.paramPath}`, {
        params: {
          page: this.page,
          professionTypeId: this.professionId
        },
      })
      this.$store.commit('error/setStatus', response.status)
      this.$store.commit('error/setMessage', response)
      if(this.paramPath === 'customers'){
        this.list = response.data.customers
        this.currentPage = this.page
        this.from = (this.page - 1) * PER_PAGE + 1
        this.to = this.from + PER_PAGE - 1
        this.lastPage = Math.ceil(this.list.length / PER_PAGE)
        this.list = this.list.slice(this.from-1, this.to)
      }else{
        this.list = response.data.data
        this.from = response.data.from
        this.to = response.data.to
        this.currentPage = response.data.current_page
        this.lastPage = response.data.last_page
      }
      this.hasData = !!this.list.length
    }
  },
}
