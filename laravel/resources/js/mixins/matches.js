import { OK } from '@/util'
export default {
  data(){
    return {
      applies: null,
      hasData: true,
    }
  },
  methods: {
    async setMatches(){
      // 申し込み側
      const matchApplies = await this.matches()
      // 募集側
      const matchedApplies = await this.matcheds()

      this.applies = matchApplies.concat(matchedApplies)
      this.hasData = this.applies.length
    },
    async matches(){
      const response = await axios.get(`/api/customers/${this.customer.id}/matches`)
      if(response.status === OK ){
        return Object.keys(response.data).map( key => response.data[key]).map( apply => {
          apply.status = this.applierStatus
          return apply
        })
      }else{
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response,
        })
      }
    },
    async matcheds(){
      const response = await axios.get(`/api/customers/${this.customer.id}/matcheds`)
      if(response.status === OK ){
        return response.data.map( apply => {
          apply.status = this.recruiterStatus
          return apply
        })
      }else{
        this.$store.commit('error/setErrors', {
          status: response.status,
          message: response,
        })
      }
    },
  }
}
