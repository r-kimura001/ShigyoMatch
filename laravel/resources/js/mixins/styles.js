import { BASE_STORAGE_URL } from "@/util";
export default {
  methods: {
    bgImage(imageSrc) {
      return {
        backgroundImage: `url(${BASE_STORAGE_URL}/${imageSrc})`,
      }
    },
    colorById(id){
      switch(id){
        case 1:
          return '#4379A9'
        case 2:
          return '#EC7211'
        case 3:
          return '#fb7272'
        case 4:
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
