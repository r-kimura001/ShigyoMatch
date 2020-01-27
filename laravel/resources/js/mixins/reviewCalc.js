import meanBy from 'lodash/meanBy'

export default {
  props: {
    customer: {
      type: Object,
      default: () => ({})
    }
  },
  computed: {
    reviewers() {
      return this.customer.reviewers
    },
    averageReview() {
      const average = meanBy(this.reviewers, 'point')
      return Math.round(average * 10) / 10
    },
    hasReview(){
      return !!this.reviewers.length
    }
  }
}
