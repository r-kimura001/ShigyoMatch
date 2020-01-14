<template>
  <div class="p-customer-details">
    <div class="MainLayout --hasWorks">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <CustomerInfoLayout
            :customer="item"
            :param-path="`customers/${id}/works`"
          ></CustomerInfoLayout>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
import apiShowHandler from '@/mixins/apiShowHandler'
import CustomerInfoLayout from '@/layouts/CustomerInfoLayout'
export default {
  components: {
    CustomerInfoLayout,
  },
  mixins: [apiShowHandler],
}
</script>
