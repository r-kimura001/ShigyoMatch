<div>
  <div class="SearchStatus u-my15" v-if="isSearching">
    <span
      v-for="(word, index) in searchingWords"
      :key="index"
      class="Tag u-ma5"
      :style="bgColor(professionId)">{{ word }}</span>
    <span class="Text -gray -fz14">で絞り込み中</span>
    <div class="BorderButton --minimum" @click="onClearClick">クリア</div>
  </div>
  <div class="SearchStatus u-my15" v-if="hasCurrentPrefecture">
    <span class="Tag u-ma5">{{ currentPrefObj.name }}</span>
    <span class="Text -gray -fz14">で絞り込み中</span>
    <div class="BorderButton --minimum" @click="clearPref">クリア</div>
  </div>
</div>

<script>
  export default {
    props: {
      isSearching: {
        type: Boolean,
        default: false
      },
      hasCurrentPrefecture: {
        type: Boolean,
        default: false
      },
      searchingWords: {
        type: Array,
        default: () => []
      },
    },
    methods: {
      onClearClick() {
        this.$emit('clear')
      }
    }
  }
</script>
