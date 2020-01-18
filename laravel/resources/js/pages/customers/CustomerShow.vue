<template>
  <div class="p-customer-show">
    <div class="MainLayout --hasWorks">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <CustomerInfoLayout
            :customer="customer"
            :paramPath="`${paramPath}/works`"
          ></CustomerInfoLayout>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
  import CustomerInfoLayout from '@/layouts/CustomerInfoLayout'
  export default {
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({})
      },
      paramPath: {
        type: String,
      }
    },
    components: {
      CustomerInfoLayout,
    },
  }
</script>
