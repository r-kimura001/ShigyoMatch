<template>
  <div class="p-works">
    <div class="MainLayout --hasWorks">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div v-if="!hasData">現在募集中の案件はありません</div>
          <div v-else>
            <h2 class="BaseTitle">
              <span class="BaseTitle_text --work"><span :style="fontColor(professionId)">{{ professionTypeName }}</span>の案件一覧</span>
            </h2>
            <div class="SearchStatus" v-if="isSearch">
              {{ `${searchingSkill[0].body}で絞り込み` }}
              <div class="BorderButton --minimum" @click="clearSearch">クリア</div>
            </div>
            <div class="Sort">
              <select @change="sortChange" v-model="sortKey">
                <option v-for="item in sortList" :value="item.value">{{ item.label }}</option>
              </select>
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
    }
  }
}
</script>
