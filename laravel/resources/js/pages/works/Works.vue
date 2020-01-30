<template>
  <div class="p-works">
    <div class="MainLayout --hasWorks">
      <div class="MainLayout_boxList">
        <div class="SearchList u-mt20" :class="{ '--open': isOpen }">
          <h2 class="SearchList_title">
            <span class="SearchList_titleText" @click="toggleBody">タグで絞り込む</span>
          </h2>
          <div class="SearchList_body">
            <ul class="SearchList_tags">
              <li class="SearchList_item" v-for="skill in skills" :key="skill.id">
                <input
                  type="checkbox"
                  :value="skill.id"
                  v-model="targetSkills"
                  :id="`skill_${skill.id}`">
                <label
                  :for="`skill_${skill.id}`"
                  class="SearchList_tag Tag u-ma5"
                  :style="colorByIsSelect(skill.id)">{{ skill.body }}</label>
              </li>
            </ul>
            <div class="u-mt15 u-alignCenter">
              <button
                class="Button --blue --hasIcon"
                :style="bgImage('assets/icon-glass-white.svg')"
                @click="searchByMultiSkill">検索</button>
            </div>
          </div>
        </div>
        <section class="MainLayout_box">
          <div class="SearchStatus" v-if="isSearch">
            <span
              v-for="(word, index) in searchingWords"
              :key="index"
              class="Tag u-ma5"
              :style="bgColor(professionId)">{{ word }}</span>で絞り込み
            <div class="BorderButton --minimum" @click="clearSearch">クリア</div>
          </div>
          <div v-if="!hasData" class="Text -nodata u-py40 u-alignCenter">結果がありません</div>
          <div v-else>
            <h2 class="BaseTitle">
              <span class="BaseTitle_text --work"><span :style="fontColor(professionId)">{{ professionTypeName }}</span>の案件一覧</span>
            </h2>
            <div class="u-alignCenter u-mb20">
              <div class="SortBox">
                <select @change="sortChange" v-model="sortKey">
                  <option v-for="item in sortList" :value="item.value">{{ item.label }}</option>
                </select>
              </div>
            </div>
            <Pager
              v-if="lastPage > 1"
              :current-page="currentPage"
              :last-page="lastPage"
              path="works"
              :professionType="professionTypeName"
            ></Pager>
            <WorkListLayout
              :works="list"
              @sendSkillId="searchBySkill"
            ></WorkListLayout>
          </div>
        </section>
      </div>
    </div>
    <button
      v-if="author"
      class="Button --pink --fixed"
      @click="toCreate()"
      >案件を募集する</button
    >
  </div>
</template>
<script>
import WorkListLayout from '@/layouts/WorkListLayout'
import apiIndexHandler from '@/mixins/apiIndexHandler'
import styles from '@/mixins/styles'
import { mapState } from 'vuex'
export default {
  components: { WorkListLayout },
  mixins: [apiIndexHandler, styles],
  data(){
    return {
      sortList: [
        {
          value: 'created_at.desc',
          label: '登録日時の新しい順'
        },
        {
          value: 'created_at.asc',
          label: '登録日時の古い順'
        },
      ]
    }
  },
  computed: {
    ...mapState({
      author: state => state.auth.customer
    })
  },
  methods: {
    toCreate(){
      if(!this.author){
        alert('募集案件を投稿するにはログインしてください')
        return false
      }else{
        this.$router.push('/works/create')
      }
    },
  }
}
</script>
