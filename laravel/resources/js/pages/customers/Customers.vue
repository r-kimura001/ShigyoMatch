<template>
  <div class="p-works">
    <div class="MainLayout --customers">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div v-if="!hasData" class="Text -nodata u-py40 u-alignCenter">結果がありません</div>
          <div v-else>
            <h3 class="BaseTitle">
              <span class="BaseTitle_text --customer"><span :style="fontColor(professionId)">{{ professionTypeName }}</span>事務所一覧</span>
            </h3>
            <div class="u-alignCenter u-mb20">
              <div class="SortBox">
                <select @change="sortChange" v-model="sortKey">
                  <option v-for="item in sortList" :value="item.value">{{ item.label }}</option>
                </select>
              </div>
            </div>
            <div class="u-mb20">
              <ResultLabel
                v-if="!!list.length"
                :total="total"
                :from="from"
                :to="to"
              ></ResultLabel>
            </div>
            <Pager
              v-if="lastPage > 1"
              :current-page="currentPage"
              :last-page="lastPage"
              path="customers"
              :professionType="professionTypeName"
            ></Pager>
            <CustomerListLayout
              :customers="list"
            ></CustomerListLayout>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import CustomerListLayout from '@/layouts/CustomerListLayout'
import apiIndexHandler from '@/mixins/apiIndexHandler'
import styles from '@/mixins/styles'

export default {
  components: { CustomerListLayout },
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
        {
          value: 'name.desc',
          label: '名前降順'
        },
        {
          value: 'name.asc',
          label: '名前昇順'
        },
      ]
    }
  }
}
</script>
