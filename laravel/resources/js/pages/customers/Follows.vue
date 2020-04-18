<template>
  <div class="p-follows">
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <h2 class="BaseTitle">
          <span class="BaseTitle_text --customer">{{ customer.name }}の<span :style="fontColor">{{ currentStatus }}</span>リスト</span>
        </h2>
        <section class="MainLayout_box">
          <Tab
            applierWord="フォロワー"
            recruiterWord="フォロー"
            :currentFlag="currentFlag"
            @tabClick="changeParam"
          ></Tab>
          <p v-if="!list.length" class="Text -nodata u-py40 u-alignCenter">{{ currentStatus }}はありません</p>
          <ul v-else class="MemberList">
            <li
              class="MemberList_item"
              v-for="(member, index) in list"
              :key="member.id"
            >
              <div class="HorizontalLayout --smCol --vertical">
                <div class="HorizontalLayout_col --flex">
                  <MemberLink :customer="member"></MemberLink>
                  <p class="MemberList_greeting">{{ member.greeting }}</p>
                </div>
                <div class="HorizontalLayout_col u-w100 u-alignRight">
                  <FollowButton
                    v-if="!self(member)"
                    :id="member.id"
                    :author="author"
                    :isFollow="checkIsFollow(member)"
                    @followClick="followClick(member)"
                  ></FollowButton>
                </div>
              </div>
            </li>
          </ul>
        </section>
      </div>
    </div>
  </div>
</template>
<script>
  import Tab from '@/components/Tab'
  import FollowButton from '@/components/FollowButton'
  import MemberLink from '@/components/MemberLink'
  import { OK } from '@/util'
  import { mapState } from 'vuex'
  export default {
    components: { Tab, MemberLink, FollowButton },
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({}),
      },
      followParam: {
        type: String,
        default: 'followers'
      }
    },
    data(){
      return {
        followerFlag: 0,
        followeeFlag: 1,
      }
    },
    computed: {
      ...mapState({
        author: state => state.auth.customer
      }),
      currentFlag(){
        return this.followParam === 'followers' ? this.followerFlag : this.followeeFlag
      },
      list() {
        const list = this.followParam === 'followers' ? this.customer.followers : this.customer.followees
        list.sort((a,b) => a.pivot.created_at < b.pivot.created_at ? 1 : -1)
        return list
      },
      currentStatus(){
        return this.followParam === 'followers' ? 'フォロワー' : 'フォロー'
      },
      fontColor(){
        const color = this.currentFlag === this.followerFlag ? '#177cc0' : '#e4406f'
        return {
          color: color
        }
      }
    },
    methods: {
      changeParam(flag){
        if(this.followerFlag === flag){
          this.$router.push(`/customers/${this.customer.id}/followers`)
        }else{
          this.$router.push(`/customers/${this.customer.id}/followees`)
        }
      },
      self(member){
        if(!this.author){
          return false
        }
        return member.id === this.author.id
      },
      checkIsFollow(member){
        if(!this.author){
          return false
        }
        if(!member.followers.length){
          return false
        }
        return member.followers.some(follower => follower.id === this.author.id)
      },
      async followClick(member){
        if(this.checkIsFollow(member)){
          await this.unfollow(member)
        }else{
          await this.follow(member)
        }
      },
      async follow(member){
        const response = await axios.put(`/api/customers/${member.id}/follow`)
        this.$store.commit('form/setResponse', response)
        if(response.status === OK){
          member.followers = response.data.followers
        }else{
          this.$store.commit('error/setErrors', {
            status: response.status,
            message: response,
          })
        }
      },
      async unfollow(member){
        const response = await axios.delete(`/api/customers/${member.id}/unfollow`)
        this.$store.commit('form/setResponse', response)
        if(response.status === OK){
          member.followers = response.data.followers
        }else{
          this.$store.commit('error/setErrors', {
            status: response.status,
            message: response,
          })
        }
      },
    }
  }
</script>
