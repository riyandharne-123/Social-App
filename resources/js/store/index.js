// store/index.js
 
import Vue from "vue";
import Vuex from "vuex";
 
Vue.use(Vuex);
 
export default new Vuex.Store({
 state: {
    user: {
        data: [],
        posts: [],
      }
 },
 getters: {},
 mutations: {
    changeUserData (state, payload) {
        state.user.data = payload
      },
      changeUserPosts (state, payload) {
        state.user.posts = payload
      },
 },
 actions: {

}
});