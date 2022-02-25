import VueRouter from 'vue-router'

// Pages
import Register from './js/vue/Auth/register.vue'
import Login from './js/vue/Auth/login.vue'
import Home from './js/vue/home.vue'
import ExampleComponent from './js/components/ExampleComponent.vue'
import UsersComponent from './js/components/UsersComponent.vue'

// Routes
const routes = [
  {
    path: '/home',
    name: 'home',
    component: Home,
    meta: {
      auth: undefined
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      auth: false
    }
  },
  {
    path: '/auth/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false
    }
  },
  // USER ROUTES
  {
    path: '/',
    name: 'ExampleComponent',
    component: ExampleComponent,
    meta: {
      auth: true
    }
  },
  {
    path: '/users',
    name: 'UsersComponent',
    component: UsersComponent,
    meta: {
      auth: true
    }
  },
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})
export default router