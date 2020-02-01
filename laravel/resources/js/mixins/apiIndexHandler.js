import { OK, PER_PAGE } from '@/util'
import Pager from '@/components/Pager'
import SortBox from '@/components/SortBox'
import { mapGetters } from 'vuex'
export default {
  components: { Pager, SortBox },
  props: {
    page: {
      type: Number,
    },
    paramPath: {
      type: String,
      required: true
    },
    professionTypeName: {
      type: String,
      default: '弁護士'
    },
  },
  data() {
    return {
      list: [],
      source: [],
      targets: [],
      skills: [],
      from: null,
      to: null,
      currentPage: null,
      lastPage: null,
      hasData: true,
      professionId: 1,
      sortKey: 'created_at.desc',
      isOpen: false
    }
  },
  watch: {
    $route: {
      async handler() {
        this.$store.commit('form/setIsLoading', true)
        this.targets = this.targetSkills
        await this.getProfessionId()
        await this.index()
        await this.selectables()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  computed:{
    ...mapGetters({
      targetSkills: 'form/targetSkills',
      searchingSkill: 'form/searchingSkill',
    }),
    isSearch(){
      return this.searchingSkill.length
    },
    searchingWords(){
      this.searchingSkill.sort((a,b) => a.id - b.id)
      return this.searchingSkill.map( skill => skill.body )
    }
  },
  methods: {
    async getProfessionId(){
      const response = await axios.get(`/api/professionId`, {
        params: {
          body: this.professionTypeName
        },
      })
      this.professionId = response.data.id
    },
    async index() {
      const response = await axios.get(`/api/${this.paramPath}`, {
        params: {
          page: this.page,
          professionTypeId: this.professionId,
          targetSkills: this.targetSkills,
          sortKey: this.sortKey,
        },
      })
      this.$store.commit('form/setResponse', response)
      this.list = response.data.data
      this.from = response.data.from
      this.to = response.data.to
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
      // this.$store.commit('error/setStatus', response.status)
      // this.$store.commit('error/setMessage', response)
      this.hasData = !!this.list.length
    },
    async selectables(){
      const response = await axios.get(`/api/professions/${this.professionId}/selectables`)
      if(response.status === OK){
        this.skills = Object.keys(response.data).map( key => response.data[key] )
      }
    },
    setPaginate(){
      this.currentPage = this.page
      this.from = (this.page - 1) * PER_PAGE + 1
      this.to = this.from + PER_PAGE - 1
    },
    async sortChange(){
      this.page = 1
      await this.index()
    },
    sortBySelect(){
      const arr = this.sortKey.split('.')
      if(arr[1] === 'desc'){
        this.list.sort( (a, b) => a[arr[0]] < b[arr[0]] ? 1 : -1)
      }else{
        this.list.sort( (a, b) => a[arr[0]] > b[arr[0]] ? 1 : -1)
      }
    },
    // WorkCardのタグを押したときの検索
    async searchBySkill(id){
      this.$store.commit('form/setIsLoading', true)
      this.targets = [id];
      await this.search()
      this.$store.commit('form/setIsLoading', false)
    },
    // 「タグで絞り込む」から検索
    async searchByMultiSkill(){
      this.$store.commit('form/setIsLoading', true)
      this.toggleBody()
      await this.search()
      this.$store.commit('form/setIsLoading', false)
    },
    async search(){
      this.$store.commit('form/setTargetSkills', this.targets)
      this.setSearchingSkill()
      this.page = 1
      await this.index()
      this.$scrollTo('.SearchList_titleText')
    },
    setSearchingSkill(){
      const searchingSkills = this.targets.map( id => this.skills.filter( skill => skill.id === id ))
      this.$store.commit('form/setSearchingSkill', searchingSkills.flat())
    },
    async clearSearch(){
      this.$store.commit('form/setIsLoading', true)
      this.targets = []
      this.$store.commit('form/setSearchingSkill', this.targets)
      this.$store.commit('form/setTargetSkills', [])
      this.page = 1
      await this.index()
      this.$scrollTo('.SearchList_titleText')
      this.$store.commit('form/setIsLoading', false)
    },
    toggleBody(){
      this.isOpen = !this.isOpen
    },
    checked(skillId){
      return this.targets.some( id => id === skillId )
    },
    colorByIsSelect(skillId){
      if(!this.targets.length){
        return this.bgColor()
      }else if(this.checked(skillId)){
        return this.bgColor(this.professionId)
      }else {
        return this.bgColor()
      }
    }
  },
}
