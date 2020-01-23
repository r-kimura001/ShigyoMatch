<template>
  <div class="Pager">
    <ul class="Pager_links">
      <RouterLink
        :to="pathObj(1)"
        tag="li"
        class="Pager_link"
        :class="{ '--edge': isFirst }"
        >&lt;
      </RouterLink>
      <RouterLink
        v-for="n of pageNumbers"
        :key="n"
        class="Pager_link"
        tag="li"
        :class="{ '--current': n === currentPage }"
        :to="pathObj(n + firstPage - 1)"
        >{{ n }}
      </RouterLink>
      <li v-if="tooLong">...</li>
      <RouterLink
        v-if="moreThan"
        :to="pathObj(lastPage)"
        tag="li"
        class="Pager_link"
        >{{ lastPage }}
      </RouterLink>
      <RouterLink
        :to="pathObj(lastPage)"
        tag="li"
        class="Pager_link"
        :class="{ '--edge': isLast }"
        >&gt;
      </RouterLink>
    </ul>
  </div>
  <!-- Pager -->
</template>
<script>
export default {
  props: {
    currentPage: {
      type: Number,
      required: true,
      default: 1,
    },
    lastPage: {
      type: Number,
      required: true,
      default: 64,
    },
    path: {
      type: String,
      required: true,
      default: '',
    },
    professionType: {
      type: String
    }
  },
  data() {
    return {
      intervalOfFirstPage: 7,
    }
  },
  computed: {
    firstPage() {
      const firstPage =
        Math.floor((this.currentPage - 1) / this.intervalOfFirstPage) *
          this.intervalOfFirstPage +
        1
      const diff =
        firstPage <= this.intervalOfFirstPage + 1
          ? 1
          : firstPage - this.intervalOfFirstPage
      return firstPage === this.lastPage ? diff : firstPage
    },
    tooLong() {
      return this.lastPage - this.firstPage > this.intervalOfFirstPage + 1
    },
    moreThan() {
      return this.lastPage - this.firstPage >= this.intervalOfFirstPage + 1
    },
    pageNumbers() {
      const pageCount = this.lastPage - this.firstPage + 1
      const pageNumbers = [...Array(pageCount).keys()].map(
        i => this.firstPage + i
      )
      return pageNumbers.slice(0, 8)
    },
    isFirst() {
      return this.currentPage === 1
    },
    isLast() {
      return this.currentPage === this.lastPage
    },
  },
  methods: {
    pathObj(page){
      return {
        path: this.path,
        query: {
          page: page,
          skill: this.professionType
        }
      }
    }
  }
}
</script>
