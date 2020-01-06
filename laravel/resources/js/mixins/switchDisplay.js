export default {
  data(){
    return {
      // 記載のパスでは無視
      ignorePathes: {
        Header: [
          '/admin',
          '/500'
        ],
        Footer: [
          '/500'
        ],
      },
      // 記載のパスでだけ表示してほしい
      onlyPathes: {
        MainVisual: [
          '/',
        ],

      }

    }
  },
  methods: {
    ignore(componentName){
      const ignore = this.ignorePathes[componentName].filter( url => { return url === this.$route.path} )
      return !!ignore.length
    },
    isOnly(componentName){
      const isOnly = this.onlyPathes[componentName].filter( url => { return url === this.$route.path} )
      return !!isOnly.length
    }
  },


}
