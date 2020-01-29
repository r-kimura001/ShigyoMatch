import Vue from 'vue'
import VueRouter from 'vue-router'

// import page component
import Top from '@/pages/Top.vue'
import Signup from '@/pages/Signup.vue'
import Login from '@/pages/Login.vue'

// works
import Works from '@/pages/works/Works.vue'
import WorkDetail from '@/pages/works/WorkDetail.vue'
import WorkShow from '@/pages/works/WorkShow.vue'
import WorkCreate from '@/pages/works/WorkCreate.vue'
import WorkEdit from '@/pages/works/WorkEdit.vue'
import WorkApply from '@/pages/works/WorkApply.vue'

// customers
import Customers from '@/pages/customers/Customers.vue'
import CustomerDetail from '@/pages/customers/CustomerDetail.vue'
import CustomerShow from '@/pages/customers/CustomerShow.vue'
import CustomerScout from '@/pages/customers/CustomerScout.vue'
import Follows from '@/pages/customers/Follows.vue'

// mypage
import MyPage from '@/pages/mypage/MyPage.vue'
import Base from '@/pages/mypage/Base.vue'
import Home from '@/pages/mypage/Home.vue'
import Applies from '@/pages/mypage/Applies.vue'
import ApplyDetail from '@/pages/mypage/ApplyDetail.vue'
import Chats from '@/pages/mypage/Chats.vue'
import Favorites from '@/pages/mypage/Favorites.vue'
import Matches from '@/pages/mypage/Matches.vue'
import Messages from '@/pages/mypage/Messages.vue'
import Profile from '@/pages/mypage/Profile.vue'
import Scouts from '@/pages/mypage/Scouts.vue'

// errors
import ServerError from '@/pages/errors/ServerError.vue'
import NotFound from '@/pages/errors/NotFound.vue'
import store from '@/store'

import AssetRegister from '@/pages/AssetRegister.vue'


// VueRouterの使用
Vue.use(VueRouter)

// パスと、パスにマッピングするコンポーネントの定義
const routes = [
  {
    path: '/',
    component: Top,
    meta: {
      title: 'Top',
    },
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
    path: '/works',
    component: Works,
    props: route => {
      const page = route.query.page
      const skill = route.query.skill
      return {
        page: /^[1-9[0-9]*$/.test(page) ? page * 1 : 1,
        paramPath: 'works',
        professionTypeName: !skill ? '弁護士' : skill
      }
    },
    meta: {
      title: '案件を探す',
    },
  },
  {
    path: '/works/create',
    component: WorkCreate,
    beforeEnter (to, from, next) {
      if (!store.getters['auth/isLogin']) {
        next('/login')
      } else {
        next()
      }
    },
  },
  {
    path: '/works/:id',
    component: WorkDetail,
    props: route => ({
      id: Number(route.params.id),
      paramPath: 'works'
    }),
    children: [
      {
        path: '/',
        component: WorkShow,
      },
      {
        path: 'edit',
        component: WorkEdit,
      },
      {
        path: 'apply',
        component: WorkApply,
      },
    ]
  },
  {
    path: '/customers',
    component: Customers,
    props: route => {
      const page = route.query.page
      const skill = route.query.skill
      return {
        page: /^[1-9[0-9]*$/.test(page) ? page * 1 : 1,
        paramPath: 'customers',
        professionTypeName: !skill ? '弁護士' : skill
      }
    },
    meta: {
      title: '人材を探す',
    },
  },
  {
    path: '/customers/:id',
    component: CustomerDetail,
    props: route => ({
      id: Number(route.params.id),
      paramPath: 'customers',
      paramPathOfWork: `customers/${route.params.id}`,
    }),
    children: [
      {
        path: '/',
        component: CustomerShow,
      },
      {
        path: 'scout',
        component: CustomerScout,
      },
      {
        path: ':followParam',
        component: Follows,
        props: route => ({ followParam: route.params.followParam }),
        beforeEnter (to, from, next) {
          const reg = /^followe[er]s$/g
          if (!to.params.followParam.match(reg)) {
            next('/not-found')
          } else {
            next()
          }
        },
      },
    ]
  },
  {
    path: '/mypage',
    component: MyPage,
    children: [
      {
        path: ':id',
        component: Base,
        props: route => ({
          id: Number(route.params.id)
        }),
        beforeEnter (to, from, next) {
          if (!store.getters['auth/isLogin']) {
            next('/')
          } else {
            next()
          }
        },
        children: [
          {
            path: '/',
            component: Home,
            meta: {
              title: 'マイページHOME',
            },
          },
          {
            path: 'applies',
            component: Applies,
          },
          {
            path: 'chats',
            component: Chats,
          },
          {
            path: 'favorites',
            component: Favorites,
          },
          {
            path: 'matches',
            component: Matches,
          },
          {
            path: 'messages',
            component: Messages,
          },
          {
            path: 'profile',
            component: Profile,
          },
          {
            path: 'scouts',
            component: Scouts,
          },
        ]
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
    path: '/*',
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
