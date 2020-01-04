import Vue from 'vue'
import VueRouter from 'vue-router'

// import page component
import Top from '@/pages/Top.vue'
import AssetRegister from '@/pages/AssetRegister.vue'

// VueRouterの使用
Vue.use(VueRouter)

// パスと、パスにマッピングするコンポーネントの定義
const routes = [
  {
    path: '/',
    component: Top,
  },
  {
    path: '/asset/register',
    component: AssetRegister,
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
