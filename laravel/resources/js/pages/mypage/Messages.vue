<template>
  <div class="p-applys">
    <h2>Messages</h2>
    <div class="MessageLayout">
      <div class="MessageLayout_sidebar">
        <h3 class="u-pa20 u-alignCenter">
          <span class="Text -bold">お相手一覧</span>
        </h3>
        <ul class="MessageLayout_roomList">
          <li
            v-for="(room, index) in rooms"
            :key="index"
            @click="setCurrentRoom(room)"
          >
            <div class="MessageLayout_room" :class="{ '--current': isCurrent(room.id) }">
              <div class="HorizontalLayout --vertical">
                <div class="HorizontalLayout_col">
                  <div class="MessageLayout_icon" :style="bgImage(target(room).file_name)">
                  </div>
                </div>
                <div class="HorizontalLayout_col u-ml10">{{ target(room).name }}</div>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="MessageLayout_main">
        <div class="MessageLayout_heading">
          <div class="HorizontalLayout --vertical --justifyCenter">
            <div class="HorizontalLayout_col">
              <div
                v-if="!!currentRoom"
                class="MessageLayout_icon"
                :style="bgImage(target(currentRoom).file_name)"
              >
              </div>
            </div>
            <div class="HorizontalLayout_col u-ml10" v-if="!!currentRoom">{{ target(currentRoom).name }}</div>
          </div>
        </div>
        <div class="MessageLayout_box">
          <ul class="MessageLayout_talks" v-if="!!currentRoom">
            <li
              v-for="(message, index) in currentRoom.messages"
              :key="index"
              class="MessageLayout_item">
              <div class="Message" :class="{ '--self': message.is_own }">
                <div v-if="message.is_own" class="Message_senderIcon" :style="bgImage(customer.file_name)"></div>
                <div v-else class="Message_senderIcon" :style="bgImage(target(currentRoom).file_name)"></div>
                <div class="Message_info">
                  <span class="Message_date">{{ message.updated_at }}</span>
                  <p class="Message_text">{{ message.body }}</p>
                </div>
              </div>
            </li>
            <li class="MessageLayout_item --end" id="end"></li>
          </ul>
          <p v-else class="MessageLayout_noRoom">ルームを選択してください</p>
        </div>
        <div class="MessageLayout_footer">
          <form @submit.prevent="store">
            <div class="HorizontalLayout --vertical">
              <div class="HorizontalLayout_col --flex">
                <textarea
                  v-model="body"
                  class="MessageLayout_formText"
                  @input="vertical"
                  :rows="rows"
                  placeholder="メッセージを入力してください"
                  :disabled="!currentRoom"></textarea>
              </div>
              <div class="HorizontalLayout_col u-alignCenter">
                <button class="Button --send" :class="{'--disable': noStr}">送信</button>
                <p class="MessageLayout_strCounter">{{ strlen }}/{{ maxStrLen }}</p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import { OK, CREATED } from '@/util'
  import styles from '@/mixins/styles'
  import WorkListLayout from '@/layouts/WorkListLayout'
  import WorkTableLayout from '@/layouts/WorkTableLayout'
  import Tab from '@/components/Tab'
  import ApplyDetail from '@/pages/mypage/ApplyDetail'
  import maxBy from 'lodash/maxBy'

  export default {
    components: { WorkListLayout, WorkTableLayout, Tab, ApplyDetail },
    props: {
      customer: {
        type: Object,
        required: true,
        default: () => ({}),
      },
    },
    mixins: [ styles ],
    data() {
      return {
        rooms: [],
        currentRoom: null,
        body: '',
        rows: 1,
        maxStrLen: 1000,
        targetIndex: null,
      }
    },
    watch: {
      $route: {
        async handler() {
          this.$store.commit('form/setIsLoading', true)
          await this.setRooms()
          this.$store.commit('form/setIsLoading', false)
        },
        immediate: true,
      },
    },
    mounted(){
      this.scrollToEnd()
    },
    computed:{
      textAreaWidth(){
        return this.$el.querySelector('.MessageLayout_formText').offsetWidth - 20
      },
      strlen(){
        return this.body.length
      },
      noStr(){
        return this.strlen === 0
      }
    },
    methods: {
      async setRooms() {
        const applyRecords = await this.msgByApplyWorks()
        const appliedRecords = await this.msgByAppliedWorks()
        applyRecords.push(appliedRecords)
        this.rooms = applyRecords.filter( applyItem => applyItem !== []).flat()
        this.rooms.sort( (a, b) => this.latestDate(a) < this.latestDate(b) ? 1 : -1)
        this.currentRoom = this.rooms[0]
      },
      async msgByApplyWorks()
      {
        const response = await axios.get(`/api/messages/${this.customer.id}/show_apply`)
        if (response.status === OK) {
          return Object.keys(response.data).map( key => response.data[key] )
        }
      },
      async msgByAppliedWorks()
      {
        const response = await axios.get(`/api/messages/${this.customer.id}/show_applied`)
        if (response.status === OK) {
          return Object.keys(response.data)
            .map( key => response.data[key] )
            .map( work => work.applies )
            .flat()
        }else{
          this.$store.commit('error/setErrors', {
            status: response.status,
            message: response,
          })
        }
      },
      async store(){
        if(this.body === ''){
          alert('メッセージを入力してください')
          return false
        }

        const messageData = new FormData()
        messageData.append('body', this.body)
        messageData.append('apply_id', this.currentRoom.id)
        messageData.append('sender_id', this.customer.id)
        this.body = ''

        const response = await axios.post('/api/messages/store', messageData)

        if(response.status === CREATED){
          this.pushMessage(this.currentRoom.id, response.data)
          this.scrollToEnd()
        }else{
          this.$store.commit('error/setErrors', {
            status: response.status,
            message: response.data.errors,
          })
        }
      },
      isApplier(room){
        return room.applier.id === this.customer.id
      },
      latestDate(apply) {
        const latestMessage = maxBy(apply.messages, message => message.updated_at)
        return latestMessage.updated_at
      },
      target(room){
        if(this.isApplier(room)){
          return room.work.customer
        }else{
          return room.applier
        }
      },
      pushMessage(id, message){
        message.is_own = true
        return this.rooms.forEach( (room, index, array) => {
          if(room.id === id){
            array[index].messages.push(message)
          }
        })
      },
      setCurrentRoom(room){
        this.currentRoom = room
        this.body = ''
        this.scrollToEnd()
      },
      isCurrent(id){
        return this.currentRoom.id === id
      },
      vertical(){
        let val = `${this.body}\n`
        this.rows = val.match(/\n/g).length
        const textWidth = (val.length - 1) * 16
        const add = Math.floor(textWidth / (this.textAreaWidth))
        this.rows += add
      },
      scrollToEnd() {
        const chatLog = this.$el.querySelector(".MessageLayout_box")
        const lastChat = this.$el.querySelector("#end")
        const positionY = lastChat.offsetTop
        chatLog.scrollTo(0, positionY)
      }
    },
  }

</script>
