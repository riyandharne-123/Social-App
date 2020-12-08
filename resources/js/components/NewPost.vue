<template>
 <b-container fluid>
 <b-row>
 <b-col cols="12">
       <b-form @submit="post">        
    <b-form-group label="Picture:" >
        <b-form-file
        :state="Boolean(form.post_image)"
        @change="GetImage"
        placeholder="Choose a file or drop it here..."
        drop-placeholder="Drop file here..."
        ></b-form-file>
    </b-form-group> 
        <div v-if="form.post_image != ''">
           <b-img :src="form.post_image" fluid alt="Responsive image"></b-img>
        </div>
      <b-form-group label="Description:" >
         <mc-wysiwyg v-model="form.post_desc"></mc-wysiwyg>
      </b-form-group> 

      <b-form-group label="Tags">
        <b-form-tags input-id="tags-basic" v-model="form.post_tags"></b-form-tags>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
    </b-form>
    </b-col>
    </b-row>
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
      form: {
      post_image:'',
      post_desc:"",
      post_tags:[],
       },
       user_name:'',
       user_image:'',
      }
    },
    methods: {
      GetImage(e){
      const reader = new FileReader();
      const ready_upload = null;
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = e => {
      this.form.post_image= e.target.result;
      }
      },
      post()
      {
       axios.post('/api/posts',{
         post_image:this.form.post_image,
         post_desc:this.form.post_desc,
         post_tags:this.form.post_tags
       })
       .then(res =>{
          this.$store.commit("changeUserPosts", res.data.posts);
        this.$bvToast.toast(`Posted!`, {
          title: 'Message',
          autoHideDelay: 3000,
          appendToast: true
        })
        this.$router.push('/app/home')
       })
       .catch(err =>{
        this.loading = false;
        this.$bvToast.toast(`Error!`, {
          title: `${err}`,
          autoHideDelay: 3000,
          appendToast: true
        })
       })
      },
    }
  }
</script>