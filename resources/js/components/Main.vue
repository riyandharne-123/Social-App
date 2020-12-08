<template>
<div>
  <b-navbar toggleable="lg" type="light" style="background-color:#fff;">
    <b-navbar-brand link to="/app" style="font-size:28px;">Social App</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item link to="/app/home" style="font-size:20px;">Home</b-nav-item>
        <b-nav-item link to="/app/users" style="font-size:20px;">Find People</b-nav-item>
         <b-nav-item link to="/app/new_post" style="font-size:20px;">New Post</b-nav-item>
        <b-nav-item-dropdown right>
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em style="font-size:20px;">
        <b-avatar variant="light" :src="user_image" class="mr-3"></b-avatar> {{ user_name }}</em>
          </template>
          <b-dropdown-item link to="/app/profile">My Profile</b-dropdown-item>
          <b-dropdown-item link @click="logout" >Sign Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
   <router-view></router-view>
</div>
</template>

<style scoped>

</style>

<script>
  export default {
      data() {
      return {
       user_name:'',
       user_image:'',
      }
    },
   created: function() {
    //fetching loggedin user data
    axios.get('/api/logged_user')
    .then(res => {
    this.$store.commit("changeUserData", res.data);
    this.user_name = res.data.name;
    this.user_image = res.data.profile_image;
    //getting data from vueX store!
   // console.log(this.$store.state.user.data);
    })
    .catch(err => {
     console.log(err)
    })
    axios.get('/api/posts')
    .then(res => {
    this.$store.commit("changeUserPosts", res.data.posts);
    })
    .catch(err => {
     console.log(err)
    })
      },
    methods: {
        logout:function()
       {
        localStorage.removeItem('token');
        localStorage.removeItem('theme');
          //routing to login page
              this.$router.push('/login').then(res => {
                  this.text = 'logged out!';
                  this.snackbar = true;
                }).catch(
                err => console.warn(err)
              );     
       },
   
    }
  }
</script>
