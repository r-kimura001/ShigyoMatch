import { BASE_STORAGE_URL, PROFESSIONS } from "@/util";
export default {
  methods: {
    bgImage(imageSrc) {
      return {
        backgroundImage: `url(${BASE_STORAGE_URL}/${imageSrc})`,
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
    thumbSrc(fileName) {
      if (fileName) {
        return `${BASE_STORAGE_URL}/${fileName}`
      } else {
        return `${BASE_STORAGE_URL}/assets/icon-no-image.png`
      }
    },
    bgColor(id) {
      return {
        backgroundColor: this.colorById(id),
      }
    },

  }
}
