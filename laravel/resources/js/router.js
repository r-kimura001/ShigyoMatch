import Vue from 'vue'
import VueRouter from 'vue-router'

// import page component
import Top from '@/pages/Top.vue'
import Signup from '@/pages/Signup.vue'
import Login from '@/pages/Login.vue'
import MyPage from '@/pages/mypages/MyPage.vue'
import Home from '@/pages/mypages/Home.vue'
import AssetRegister from '@/pages/AssetRegister.vue'

// errors
import ServerError from '@/pages/errors/ServerError.vue'
import NotFound from '@/pages/errors/NotFound.vue'
import store from '@/store'

// VueRouterの使用
Vue.use(VueRouter)

// パスと、パスにマッピングするコンポーネントの定義
const routes = [
  {
    path: '/',
    component: Top,
  },
  {
    path: '/signup',
    component: Signup,
  },
  {
    path: '/login',
    component: Login,
    beforeEnter (to, from, next) {
      if (store.getters['auth/isLogin']) {
        next('/')
      } else {
        next()
      }
    }
  },
  {
    path: '/mypage',
    component: MyPage,
    beforeEnter (to, from, next) {
      if (!store.getters['auth/isLogin']) {
        next('/')
      } else {
        next()
      }
    },
    children: [
      {
        path: ':id',
        component: Home,
        props: route => ({
          id: Number(route.params.id)
        }),
      },
    ],
  },
  {
    path: '/asset/register',
    component: AssetRegister,
  },
  {
    path: '/500',
    component: ServerError,
  },
  {
    path: '/not-found',
    component: NotFound,
  },
]

// VueRouterのインスタンスをrouterとして定義
const router = new VueRouter({
  mode: 'history',
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes,
})

// routerをapp.jsでインポートするためにエクスポート
export default router
