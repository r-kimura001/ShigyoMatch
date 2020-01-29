<template>
  <div class="p-works">
    <div class="MainLayout --customers">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div v-if="!hasData">登録された事務所はありません</div>
          <div v-else>
            <div class="">
              <!-- menubar -->
            </div>
            <div>
              <div>
                <h2 class="BaseTitle">
                  <span class="BaseTitle_text --customer"><span :style="fontColor(professionId)">{{ skill }}</span>事務所一覧</span>
                </h2>
                <div class="Sort">
                  <select @change="sortChange" v-model="sortKey">
                    <option v-for="item in sortList" :value="item.value">{{ item.label }}</option>
                  </select>
                </div>
                <Pager
                  v-if="lastPage > 1"
                  :current-page="currentPage"
                  :last-page="lastPage"
                  path="customers"
                  :professionType="skill"
                ></Pager>
              </div>
              <CustomerListLayout :customers="list"></CustomerListLayout>
            </div>
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
