<template>
  <div class="p-applys">
    <h2>Messages</h2>
    <div class="MessageLayout">
      <div class="MessageLayout_sidebar">
        <h3 class="MessageLayout_sidebarTitle" :class="{'--open': isOpen}" @click="toggleRoom">
          <span class="Text -bold">お相手一覧</span>
        </h3>
        <ul
          v-if="rooms.length"
          class="MessageLayout_roomList"
          :class="{'--open': isOpen}"
        >
          <li
            v-for="(room, index) in rooms"
            :key="index"
            @click="setCurrentRoom(room)"
            class="MessageLayout_roomWrap"
          >
            <div class="MessageLayout_room"
                 :class="roomClassList(room)"
                 :data-unread="unreadCount(room)">
              <RouterLink :to="`/works/${room.work.id}`" tag="div" class="HorizontalLayout --vertical">
                <div class="HorizontalLayout_col u-ml10">
                  <span class="Text -link -fz12">{{ room.work.title }}</span>
                </div>
              </RouterLink>
              <MemberLink :customer="target(room)" :no-link="true"></MemberLink>
            </div>
          </li>
        </ul>
        <p
          v-else
          class="MessageLayout_noRoomText"
          :class="{'--open': isOpen}"
        >現在お相手はいません。<br>メッセージの開始は、案件の募集者からのみ、任意の申込者に対してすることができます。</p>
      </div>
      <div class="MessageLayout_main">
        <div class="MessageLayout_heading">
          <MemberLink v-if="!!currentRoom" :customer="target(currentRoom)" :white="true" class="HorizontalLayout --vertical --justifyCenter"></MemberLink>
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
                  <span class="Message_date">{{ createdAt(message.created_at) }}</span>
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
  import { OK, CREATED, DELETED, dateReplace } from '@/util'
  import styles from '@/mixins/styles'
  import Tab from '@/components/Tab'
  import ApplyDetail from '@/pages/mypage/ApplyDetail'
  import MemberLink from '@/components/MemberLink'
  import maxBy from 'lodash/maxBy'
  export default {
    components: { Tab, ApplyDetail, MemberLink },
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
        isOpen: true
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
        messageData.append('receiver_id', this.target(this.currentRoom).id)
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
      async setCurrentRoom(room){
        this.currentRoom = room
        this.toggleRoom()
        this.body = ''
        const response = await this.read(room)
        this.$emit('readed', {
          prop: 'message_notes',
          key: 'message_id',
          ids: room.messages.filter( msg => msg.is_note).map( msg => msg.id )
        })
        if(response.status === DELETED){
          room.messages.forEach( msg => {
            msg.is_note = false
            msg.note = null
          })
        }
        this.scrollToEnd()
      },
      async read(room){
        return await axios.delete(`/api/applies/${room.id}/messages`)
      },
      isCurrent(id){
        return !this.currentRoom ? false : this.currentRoom.id === id
      },
      unreadCount(room){
        return room.messages.filter( message => message.is_note).length
      },
      roomClassList(room){
        return {
          '--current': this.isCurrent(room.id),
          '--hasUnread': this.unreadCount(room),
        }
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
      },
      toggleRoom(){
        this.isOpen = !this.isOpen
      },
      createdAt(created_at){
        return dateReplace(created_at)
      }
    },
  }

</script>
