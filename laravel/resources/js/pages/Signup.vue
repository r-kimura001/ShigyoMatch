<template>
  <div class="p-signup" :style="bgImage()">
    <Loader :class="{ '--show': isLoading }" />
    <div class="MainLayout">
      <div class="MainLayout_boxList">
        <section class="MainLayout_box">
          <div class="LoginFormLayout">
            <div class="Form --auth">
              <form @submit.prevent="register">
                <div class="Form_row">
                  <div class="Form_errorBox">
                    <div v-if="hasError('email')">
                      <small
                        v-for="(errorMessage, index) in errorMessages.email"
                        :key="index"
                        class="ValidationErrorMessage"
                        >{{ errorMessage }}</small
                      >
                    </div>
                  </div>
                  <input
                    v-model="customerData.email"
                    type="email"
                    class="Form_text"
                    placeholder="sample@example.com"
                    required
                    autofocus
                  />
                </div>
                <div class="Form_row">
                  <div class="Form_errorBox">
                    <div v-if="hasError('name')">
                      <small
                        v-for="(errorMessage, index) in errorMessages.name"
                        :key="index"
                        class="ValidationErrorMessage"
                        >{{ errorMessage }}</small
                      >
                    </div>
                  </div>
                  <input
                    v-model="customerData.name"
                    type="text"
                    class="Form_text"
                    placeholder="XXX法律事務所"
                    required
                  />
                </div>
                <div class="Form_row --fetchInfos">
                  <div class="Form_infoLoader" :class="{ '--show': isWaiting }">
                    <vue-loading
                      type="spiningDubbles"
                      color="#cccccc"
                      :size="{ width: '60px', height: '60px' }"
                    ></vue-loading>
                  </div>
                  <div
                    v-for="(professionType, index) in professionTypes"
                    :key="index"
                  >
                    <input
                      v-model="customerData.professionIds"
                      type="checkbox"
                      :value="professionType.id"
                    />{{ professionType.body }}
                    <div class="Form_textWrapper">
                      <input
                        v-model="
                          customerData.registerNumbers[professionType.id]
                        "
                        :class="boxChecked(professionType.id)"
                        type="text"
                        class="Form_text"
                        placeholder="登録番号"
                      />
                    </div>
                  </div>
                </div>
                <div class="Form_row u-alignCenter">
                  <button
                    class="Form_button Button --hasShadow --pink"
                    :class="{ '--disable': isWaiting }"
                  >
                    上記内容で登録
                  </button>
                </div>
              </form>
            </div>
          </div>
        </section>
        <!-- MainLayout_box -->
      </div>
      <!-- MainLayout_boxList -->
    </div>
    <!-- MainLayout -->
  </div>
  <!-- p-signup -->
</template>
<script>
import { mapState, mapGetters } from 'vuex'
import { BASE_ASSET_URL } from '@/util'
import Loader from '@/components/Loader'
import { VueLoading } from 'vue-loading-template'

export default {
  components: {
    Loader,
    VueLoading,
  },
  data() {
    return {
      customerData: {
        email: '',
        name: '',
        professionIds: [],
        registerNumbers: {},
      },
      professionTypes: null,
      isLoading: false,
      isWaiting: false,
    }
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      errorMessages: state => state.auth.registerErrorMessages,
    }),
    ...mapGetters({
      customerId: 'auth/customerId',
    }),
  },
  watch: {
    // routeを監視してページが切り替わったときにfetchList()が実行されるよう記述
    // さらにimmediate: true にしているのでコンポーネントが生成されたタイミングでも実行される
    $route: {
      async handler() {
        await this.fetchProfessions()
      },
      immediate: true,
    },
  },
  methods: {
    boxChecked(id) {
      return {
        '--disable': this.customerData.professionIds.indexOf(id) === -1,
      }
    },
    hasError($prop) {
      return (
        this.errorMessages !== null &&
        Object.keys(this.errorMessages).indexOf($prop) >= -1
      )
    },
    async fetchProfessions() {
      this.isWaiting = true
      const response = await axios.get('/api/professions')
      this.professionTypes = response.data
      this.isWaiting = false
    },

    async register() {
      this.isLoading = true
      //フォームデータの整形
      const formData = new FormData()
      formData.append('email', this.customerData.email)
      formData.append('name', this.customerData.name)
      formData.append('professionIds', this.customerData.professionIds)
      formData.append(
        'registerNumbers',
        JSON.stringify(this.customerData.registerNumbers)
      )
      formData.append('professionTypes', this.customerData.professionTypes)

      await this.$store.dispatch('auth/register', formData)
      this.isLoading = false

      if (this.apiStatus) {
        // マイページに移動する
        this.$router.push(`/mypage/${this.customerId}`)
      }
    },

    bgImage() {
      return {
        backgroundImage: `url(${BASE_ASSET_URL}/bg-login.jpg)`,
      }
    },
  },
}
</script>
