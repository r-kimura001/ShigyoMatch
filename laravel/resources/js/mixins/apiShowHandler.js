import { mapGetters } from 'vuex'
import { OK } from '@/util'
export default {
  props: {
    id: {
      type: Number,
      required: true,
    },
    paramPath: {
      type: String,
      required: true
    }
  },
  data(){
    return {
      item: {}
    }
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        await this.fetchItem()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  methods: {
    async fetchItem() {
      const response = await axios.get(`/api/${this.paramPath}/${this.id}`)
      this.$store.commit('error/setStatus', response.status)
      this.$store.commit('error/setMessage', response)
      if(response.status === OK){
        this.item = response.data
      }
    },
  },
}
