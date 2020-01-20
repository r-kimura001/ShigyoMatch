<template>
  <div>
    <section class="MypageContent_box">
      <div class="MypageContent_tabs">
        <Tab
          :current-flag="currentFlag"
          :apply-flag="applyFlag"
          :recruit-flag="appliedFlag"
          @tabClick="change"
        ></Tab>
      </div>
      <div class="MypageContent_body">
        <div v-if="currentFlag===applyFlag" class="">
          <p v-if="!hasApplyWorks">申込をした募集案件はありません</p>
          <WorkListLayout
            v-else
            :works="apply_works"
          ></WorkListLayout>
        </div>
        <div v-if="currentFlag===appliedFlag">
          <p v-if="!hasAppliedWorks">申込を受けた募集案件はありません</p>
          <div v-else class="Table">
            <table>
              <thead>
              <tr>
                <th class="Table_headText">募集タイトル</th>
                <th class="Table_headText">申込者</th>
                <th class="Table_headText">申込日時</th>
                <th class="Table_headText">操作</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(applier, index) in appliers" :key="index">
                <td>
                  <RouterLink
                    :to="`/works/${applier.work.id}`"
                    tag="span"
                    class="Table_dataText --link --hasIcon"
                    :style="bgImage(applier.work.file_name)"
                  >
                    {{ applier.work.title }}
                  </RouterLink>
                </td>
                <td>
                  <RouterLink
                    :to="`/customers/${applier.id}`"
                    tag="span"
                    class="Table_dataText --link --hasIcon"
                    :style="bgImage(applier.file_name)"
                  >
                    {{ applier.name }}
                  </RouterLink>
                </td>
                <td>
                  <div class="Table_dataText">{{ applier.pivot.created_at }}</div>
                </td>
                <td>
                  <RouterLink
                    :to="`/mypage/${customer.id}/applies/${applier.pivot.id}`"
                    class="Button --minimum"
                    :applier="applier"
                  >
                    詳細
                  </RouterLink>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import styles from '@/mixins/styles'
  import WorkListLayout from '@/layouts/WorkListLayout'
  import WorkTableLayout from '@/layouts/WorkTableLayout'
  import Tab from '@/components/Tab'
  export default {
    components: { WorkListLayout, WorkTableLayout, Tab },
    mixins: [ styles ],
  }
</script>
