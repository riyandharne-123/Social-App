<template>
<b-container fluid>
  <b-row style="padding-top:6%;" class="justify-content-md-center">
    <b-col sm="8" align="center">
    <b-col>
     <b-form-input v-model="search" placeholder="Search for a user..."
      @keydown="searching = true"
      @keyup="searching = false"
      ></b-form-input>
      <b-spinner variant="primary" label="Spinning" v-if="searching"></b-spinner>
     </b-col>     
    </b-col>
  </b-row>
  <b-row style="padding-top:3%;" class="justify-content-md-center">
    <b-col sm="8" align="center">
    <b-list-group>
      <b-list-group-item class="d-flex align-items-center" v-for="user in filterUsersByCategory" :key="user.id">
        <b-avatar variant="light" :src="user.profile_image" class="mr-3"></b-avatar>
        <span class="mr-auto"><strong>{{user.name}}</strong></span>
        <!--v-if="following_users.indexOf(`${user.id}`) !== -1"-->
          <b-col lg="4" class="pb-2" v-if="following_users.indexOf(`${user.id}`) !== -1">
           <b-button variant="primary" @click="unfollowing(user.email,user.name)">Unfollow <b-icon-person-x /></b-button>
          </b-col>
         <b-col lg="4" class="pb-2" v-else>
           <b-button variant="outline-primary" @click="following(user.email,user.profile_image,user.name,user.id)">Follow <b-icon-person-plus-fill /></b-button>
          </b-col>
      </b-list-group-item>
    </b-list-group>
    </b-col>
  </b-row>
</b-container>
</template>

<script>
export default {
        data() {
      return {
        search:'',
        searching:false,
        users:'',
        following_users:[],
        user_id:this.$store.state.user.data.id,
      }
    },
   created: function() {
    //fetching loggedin user data
    axios.get('/api/users')
    .then(res => {
    this.users= res.data;
    })
    .catch(err => {
     console.log(err)
    })
    //fetching following user details
    axios.get('/api/following')
    .then(res => {
    this.user_id = this.$store.state.user.data.id
    this.following_users = res.data.following_users;
    })
    .catch(err => {
     console.log(err)
    })
      },
    methods: {
       true_searching()
       {
           this.searching = true;
       },
       following(user_email,user_profile_image,user_name,user_id)
       {
         axios.post('/api/following',{
           user_id:user_id,
           email: user_email,
           name:user_name,
           profile_image: user_profile_image,
         }).then(res=>{
          this.following_users = res.data.following_users;
          this.$store.commit("changeUserData", res.data.user_data);
          this.$bvToast.toast(`${res.data.message}`, {
          title: 'Message',
          autoHideDelay: 3000,
          appendToast: true
        })
         })
         .catch(err=>{
           console.warn(err)
         })
       },
       unfollowing(user_email,user_name){
           axios.post(`/api/unfollow/`,{
           user_id:this.user_id,
           email: user_email,
           name:user_name,
         }).then(res=>{
          this.following_users = res.data.following_users;
          this.$store.commit("changeUserData", res.data.user_data);
          this.$bvToast.toast(`${res.data.message}`, {
          title: 'Message',
          autoHideDelay: 3000,
          appendToast: true
        })
         })
         .catch(err=>{
           console.warn(err)
         })
       },
    },
     computed: {
      filterUsersByCategory: function(){
        return Object.values(this.users).filter(user => !user.name.indexOf(this.search))
      }
    },
  }
</script>
