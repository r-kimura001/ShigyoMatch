import { OK, PER_PAGE } from '@/util'
import Pager from '@/components/Pager'
import SortBox from '@/components/SortBox'

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
      searchedWorks: [],
      skills: [],
      targetSkills: [],
      searchingSkill: [],
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
        await this.getProfessionId()
        await this.index()
        await this.selectables()
        this.$store.commit('form/setIsLoading', false)
      },
      immediate: true,
    },
  },
  computed:{
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
          professionTypeId: this.professionId
        },
      })
      this.$store.commit('error/setStatus', response.status)
      this.$store.commit('error/setMessage', response)
      const reg = /^(customers|works)$/g
      if(!this.paramPath.match(reg)){
        this.list = response.data.data
        this.from = response.data.from
        this.to = response.data.to
        this.currentPage = response.data.current_page
        this.lastPage = response.data.last_page
      }else{
        this.source = response.data[this.paramPath]
        this.searchedWorks = this.source
        this.sortBySelect()
        this.setPaginate()
        this.lastPage = Math.ceil(this.source.length / PER_PAGE)
        this.list = this.source.slice(this.from-1, this.to)
      }
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
    sortChange(){
      this.sortBySelect()
      this.page = 1
      this.setPaginate()
      this.list = this.searchedWorks.slice(this.from-1, this.to)
    },
    sortBySelect(){
      const arr = this.sortKey.split('.')
      if(arr[1] === 'desc'){
        this.searchedWorks.sort( (a, b) => a[arr[0]] < b[arr[0]] ? 1 : -1)
      }else{
        this.searchedWorks.sort( (a, b) => a[arr[0]] > b[arr[0]] ? 1 : -1)
      }
    },
    searchBySkill(id){
      this.targetSkills = [id]
      this.searchingSkill = []
      this.searchedWorks = []
      this.setSearchingSkill(id)
      this.setSearchedWork(id)
      this.searchingSkill = this.searchingSkill.flat()
      this.searchedWorks = this.searchedWorks.flat()
      this.page = 1
      const count = !this.searchedWorks.length ? 1 : this.searchedWorks.length
      this.lastPage = Math.ceil(count / PER_PAGE)
      this.setPaginate()
      this.list = this.searchedWorks.slice(this.from-1, this.to)
    },
    searchByMultiSkill(){
      this.toggleBody()
      this.searchingSkill = []
      this.searchedWorks = []
      this.targetSkills.forEach( id => {
        this.setSearchingSkill(id)
        this.setSearchedWork(id)
      })
      this.searchingSkill = this.searchingSkill.flat()
      this.searchedWorks = this.searchedWorks.flat()
      this.page = 1
      const count = !this.searchedWorks.length ? 1 : this.searchedWorks.length
      this.lastPage = Math.ceil(count / PER_PAGE)
      this.setPaginate()
      this.list = this.searchedWorks.slice(this.from-1, this.to)
    },
    setSearchingSkill(id){
      this.searchingSkill.push(this.skills.filter( skill => skill.id === id ))
    },
    setSearchedWork(id){
      this.searchedWorks.push(this.source.filter( work => {
        if(!work.skills.length){
          return false
        }
        return work.skills.some( skill => skill.id === id )
      }))
    },
    clearSearch(){
      this.searchedWorks = this.source
      this.searchingSkill = []
      this.targetSkills = []
      this.page = 1
      this.setPaginate()
      this.lastPage = Math.ceil(this.source.length / PER_PAGE)
      this.list = this.source.slice(this.from-1, this.to)
    },
    toggleBody(){
      this.isOpen = !this.isOpen
    },
    checked(skillId){
      return this.targetSkills.some( id => id === skillId )
    },
    colorByIsSelect(skillId){
      if(!this.targetSkills.length){
        return this.bgColor()
      }else if(this.checked(skillId)){
        return this.bgColor(this.professionId)
      }else {
        return this.bgColor()
      }
    }
  },
}
