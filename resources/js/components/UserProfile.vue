<template>
<b-container fluid>
  <b-row style="padding-top:3%;">
    <b-col align="center" >
        <b-card
        :title="user_name"
        tag="article"
        img-top class="mb-3"
        >
        <b-img fluid rounded="circle" alt="Circle image" :src="user_image"></b-img>
        <b-card-text fluid>
        <h5>Following: {{user_following}}  Followers: {{user_followers}}</h5>
        <hr>
        <p v-html="user_description">
        </p>
        <hr>
         <h6>Account created at:- {{created_at}}</h6>
        </b-card-text>
         <b-row>
          <b-col >
          <b-button variant="primary" v-b-modal.edit-profile-modal> <b-icon icon="tools"></b-icon> Edit Profile</b-button>
          </b-col>
         </b-row>
        </b-card>
        </b-col>

         <div>
         <b-col v-for="post in user_posts" :key="post.id">
        <b-card
          :img-src="post.post_image"
          img-alt="Image"
          img-top
          tag="article"
          class="mb-2"
        >
          <b-card-text>
           <p v-html="post.post_desc"></p>
          </b-card-text>

          <b-button variant="danger" @click="delete_post(post.id)"><b-icon-trash /></b-button>
        </b-card>      
        </b-col>
      </div>
  </b-row>
  <b-modal size="xl" id="edit-profile-modal" title="Edit Profile">
       <b-form @submit="update_profile">
      <b-form-group
        label="New Name:"
      >
        <b-form-input
          type="text"
          :value="user_name"
           v-model="form.name"
          required
          placeholder="Enter new name"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group" label="Your description:" >
         <mc-wysiwyg :value="user_description" v-model="form.desc"></mc-wysiwyg>
      </b-form-group> 

    <b-form-group id="input-group" label="Your profile picture:" >
        <b-form-file
        :state="Boolean(form.profile_image)"
        @change="GetImage"
        placeholder="Choose a file or drop it here..."
        drop-placeholder="Drop file here..."
        ></b-form-file>
      </b-form-group> 

      <b-form-group v-if="this.form.profile_image">
    <b-img :src="this.form.profile_image" fluid alt="Responsive image"></b-img>
      </b-form-group>

      <b-button type="submit" variant="success">Update Profile</b-button>
    </b-form>
  </b-modal>
</b-container>
</template>

<script>
import { McWysiwyg } from '@mycure/vue-wysiwyg';

  export default {
  components: {
    McWysiwyg
  },
    data() {
      return {
        user_posts:[],
        user_id:this.$store.state.user.data.id,
        user_name:this.$store.state.user.data.name,
        user_image:this.$store.state.user.data.profile_image,
        created_at:this.$store.state.user.data.created_at,
        user_description:this.$store.state.user.data.description,
        user_following:this.$store.state.user.data.following,
        user_followers:this.$store.state.user.data.followers,
        desc:false,
          form: {
          name:this.$store.state.user.data.name,
          desc:this.$store.state.user.data.description,
          profile_image:null,
        },
      }
    },
    mounted()
    {
     //checking weather user desc exists or not
     if(this.$store.state.user.data.description == null)
     {
       this.desc = false
     }
     else
     {
       this.desc = true
     }
     axios.get('/api/user_posts')
     .then(res =>{
       this.user_posts = res.data.posts
     })
     .catch(err =>{
       console.warn(err)
     })
    },
    methods: {
      GetImage(e){
      const reader = new FileReader();
      const ready_upload = null;
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = e => {
      this.form.profile_image= e.target.result;
      }
    },
    delete_post(post_id)
    {
     axios.delete(`/api/user_posts/${post_id}`)
       .then(res =>{
       this.user_posts = res.data.posts
     })
     .catch(err =>{
       console.warn(err)
     })
    },
    update_profile(){
        //edit user profile req
          axios.put('/api/users/'+this.user_id,{
            'name':this.form.name,
            'description':this.form.desc,
            'profile_image':this.form.profile_image,
            })
         .then(res =>{
            this.$store.commit("changeUserData", res.data);
            this.form.name = this.$store.state.user.data.name
            this.form.desc = this.$store.state.user.data.description
            this.user_id = this.$store.state.user.data.id
            this.user_name = this.$store.state.user.data.name
            this.user_image = this.$store.state.user.data.profile_image
            this.created_at = this.$store.state.user.data.created_at
            this.user_description = this.$store.state.user.data.description
            this.user_following = this.$store.state.user.data.following
            this.user_followers = this.$store.state.user.data.followers
            this.$bvModal.hide('edit-profile-modal')
           })
        .catch(err => console.warn(err))
    },
   }
  }
</script>
