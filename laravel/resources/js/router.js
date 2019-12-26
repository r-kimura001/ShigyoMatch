import Vue from 'vue'
import VueRouter from 'vue-router'

// import page component
import Top from '@/pages/Top.vue'

// VueRouterの使用
Vue.use(VueRouter)

// パスと、パスにマッピングするコンポーネントの定義
const routes = [
  {
    path: '/',
    component: Top,
  },
]

// VueRouterのインスタンスをrouterとして定義
const router = new VueRouter({
  mode: 'history',
  scrollBehavior(to, from, savedPosition) {
    return { x: 0, y: 0 }
  },
  routes,
})

// routerをapp.jsでインポートするためにエクスポート
export default router
