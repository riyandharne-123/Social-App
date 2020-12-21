<template>
  <b-container fluid>
  <b-row style="padding-top:5%;">
  <b-col align="center">
  <b-card
    title="Create a new account"
    img-src="https://picsum.photos/600/300/?image=35"
    img-alt="Image"
    img-top
    tag="article"
    style="max-width: 30rem;"
    class="mb-2"
  >
    <b-card-text>
     <b-row>
      <b-col>
      <b-form @reset="onReset" @submit="register" v-if="show">
      
      <b-form-group label="Your Name:" description="Nice to meet you!">
        <b-form-input
          v-model="form.name"
          required
          type="text"
          placeholder="Enter your full name"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        label="Email address:"
        description="We'll never share your email with anyone else."
      >
        <b-form-input
          v-model="form.email"
          type="email"
          required
          placeholder="Enter email"
        ></b-form-input>
      </b-form-group>

      
    <b-form-group label="Your profile picture:" >
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

      <b-form-group label="Your Password:"  description="it's a secret.">
        <b-form-input
          v-model="form.password"
          required
          type="password"
          placeholder="Enter Password"
        ></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
    </b-form>
         <b-spinner  v-if="loading" class="m-5" label="Busy"></b-spinner>
      </b-col>
     </b-row>
    <hr>
    <b-col><p>Already have an account? <b-link link to='/login'>Login</b-link></p></b-col>
    </b-card-text>
  </b-card>
  </b-col>
  </b-row>
</b-container>
</template>

<script>
   export default {
    data() {
      return {
        form: {
          email: '',
          name: '',
          password:'',
          profile_image:null,
        },
        show: true,
        show_submit: false,
        loading:false,
      }
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
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.password = ''
        this.form.name = ''
      },

   //register function api
    register:function()
    {
      this.loading = true;
      axios.post('/api/register', {
        'name':this.form.name,
        'email':this.form.email,
        'password':this.form.password,
        'profile_image':this.form.profile_image,
      }).then(res => {
      localStorage.setItem('token',res.data.token);
      localStorage.setItem('loggedIn',true);
      //routing to admin panel
      this.$router.push('/app/home').then(
        res => console.log('logged in')
      ).catch(
        err => console.warn(err)
      );
      })
      .catch(err =>{
        console.dir(err.response.data)
      });
     return false; 
     },
    }, 
  }
</script>
