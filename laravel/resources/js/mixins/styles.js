import { BASE_STORAGE_URL, PROFESSIONS } from "@/util";
export default {
  methods: {
    bgImage(imageSrc, flag='office') {
      if(imageSrc){
        return {
          backgroundImage: `url(${BASE_STORAGE_URL}/${imageSrc})`,
        }
      }else if(flag === 'office'){
        return {
          backgroundImage: `url(${BASE_STORAGE_URL}/assets/thumb-office-no-image.svg)`,
        }
      }else{
        return false
      }
    },
    colorById(id){
      switch(id){
        case PROFESSIONS.bengoshi:
          return '#4379A9'
        case PROFESSIONS.shihoushoshi:
          return '#EC7211'
        case PROFESSIONS.gyoseishoshi:
          return '#fb7272'
        case PROFESSIONS.zeirishi:
          return '#69D9A1'
        default:
          return '#a8a3a7'
      }
    },
    thumbSrc(fileName, flag='office') {
      if (fileName) {
        return `${BASE_STORAGE_URL}/${fileName}`
      } else if(flag==='office'){
        return `${BASE_STORAGE_URL}/assets/thumb-office-no-image.svg`
      } else{
        return `${BASE_STORAGE_URL}/assets/thumb-work-no-image.svg`
      }
    },
    bgColor(id) {
      return {
        backgroundColor: this.colorById(id),
      }
    },

  }
}
