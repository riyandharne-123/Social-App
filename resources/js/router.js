import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'

import Login from './components/Login'
import Register from './components/Register'
import Main from './components/Main'
import UserProfile from './components/UserProfile'
import Home from './components/Home'
import Users from './components/Users'
import User from './components/User'
import NewPost from './components/NewPost'
import NotFound from './components/NotFound'

Vue.use(VueRouter)

const routes = [
  {
   path:'/',
   redirect:'/login',
  },
  {
    path:'/login',
    component:Login,
    name:'Login',
  },
  {
    path:'/register',
    component:Register,
    name:'Register',
  },
  {
    path:'/app',
    redirect:'/app/home',
    beforeEnter: (to,from,next) => {
      axios.get('/api/verify_user')
      .then(res => {
        if(res.data.api_token == localStorage.getItem('token'))
        {
          next()
        }
      })
      .catch(err => 
        next('/login'))
      }
   },
  {
    path:'/app',
    component:Main,
    name:'Main',
    beforeEnter: (to,from,next) => {
      axios.get('/api/verify_user')
      .then(res => {
        if(res.data.api_token == localStorage.getItem('token'))
        {
          next()
        }
      })
      .catch(err => 
        next('/login'))
      },
    children: [
      {
        path: 'profile',
        component: UserProfile,
        name:'UserProfile',
        beforeEnter: (to,from,next) => {
          axios.get('/api/verify_user')
          .then(res => {
            if(res.data.api_token == localStorage.getItem('token'))
            {
              next()
            }
          })
          .catch(err => 
            next('/login'))
          },
      },
      {
        path: 'home',
        component: Home,
        name:'Home',
        beforeEnter: (to,from,next) => {
          axios.get('/api/verify_user')
          .then(res => {
            if(res.data.api_token == localStorage.getItem('token'))
            {
              next()
            }
          })
          .catch(err => 
            next('/login'))
          },
      },
      {
        path: 'new_post',
        component: NewPost,
        name:'NewPost',
        beforeEnter: (to,from,next) => {
          axios.get('/api/verify_user')
          .then(res => {
            if(res.data.api_token == localStorage.getItem('token'))
            {
              next()
            }
          })
          .catch(err => 
            next('/login'))
          },
      },
      {
        path: 'users',
        component: Users,
        name:'Users',
        beforeEnter: (to,from,next) => {
          axios.get('/api/verify_user')
          .then(res => {
            if(res.data.api_token == localStorage.getItem('token'))
            {
              next()
            }
          })
          .catch(err => 
            next('/login'))
          },
      },
      {
        path: 'user/:id',
        component: User,
        name:'User',
        beforeEnter: (to,from,next) => {
          axios.get('/api/verify_user')
          .then(res => {
            if(res.data.api_token == localStorage.getItem('token'))
            {
              next()
            }
          })
          .catch(err => 
            next('/login'))
          },
      },
    ],
  },
  {
    path:'*',
    component:NotFound,
    name:'NotFound',
  },
]

const router = new VueRouter({routes})

//auth guard
router.beforeEach((to,from,next) => {
  const jwtToken = `Bearer ${localStorage.getItem('token')}`;
window.axios.defaults.headers.common['authorization'] = jwtToken;
  next();
})

export default router