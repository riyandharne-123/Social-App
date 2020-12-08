window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import router from './router'
import store from './store'
import VueWysiwyg from '@mycure/vue-wysiwyg';
Vue.use(VueWysiwyg);

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import App from './components/App'
import Login from './components/Login'
import Register from './components/Register'
import Main from './components/Main'
import UserProfile from './components/UserProfile'
import Home from './components/Home'
import Users from './components/Users'
import NewPost from './components/NewPost'
import NotFound from './components/NotFound'
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

 app = new Vue({
    el: '#app',
    router,
    store,
    components:{
        'App':App,
        'Login':Login,
        'Register':Register,
        'NotFound':NotFound,
        'Main':Main,
        'UserProfile':UserProfile,
        'Users':Users,
        'Home':Home,
        'NewPost':NewPost,
        },
});
