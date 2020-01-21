<template>
  <div class="MainLayout">
    <div class="MainLayout_boxList">
      <p v-if="isApplied" class="Text -danger">この募集案件には既に申込済みです</p>
      <p v-else-if="isScouted" class="Text -success">スカウトされています</p>
      <section class="MainLayout_box">
        <WorkDetailLayout :work="work"></WorkDetailLayout>
      </section>
    </div>
    <RouterLink v-if="canApply" :to="`/works/${work.id}/apply`" tag="button" class="Button --blue --fixed"
    >この案件に応募する</RouterLink>
  </div>
</template>
<script>
  import WorkDetailLayout from '@/layouts/WorkDetailLayout'
  import worksData from '@/mixins/worksData'
  export default {
    components: {
      WorkDetailLayout
    },
    mixins: [worksData]
  }
</script>
