import { BASE_STORAGE_URL } from "@/util";
export default {
  methods: {
    bgImage(dirType = 'assets', imageSrc) {
      return {
        backgroundImage: `url(${BASE_STORAGE_URL}/${dirType}/${imageSrc})`,
      }
    },
  }
}
