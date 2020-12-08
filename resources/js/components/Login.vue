<template>
  <b-container fluid>
  <b-row style="padding-top:5%;">
  <b-col align="center">
  <b-card
    title="Welcome Please Login"
    img-src="https://picsum.photos/600/300/?image=25"
    img-alt="Image"
    img-top
    tag="article"
    style="max-width: 30rem;"
    class="mb-2"
  >
    <b-card-text>
      <b-form @reset="onReset" @submit="login" v-if="show">
      <b-form-group
        id="input-group-1"
        label="Email address:"
        label-for="input-1"
        description="We'll never share your email with anyone else."
      >
        <b-form-input
          id="input-1"
          v-model="form.email"
          type="email"
          required
          placeholder="Enter email"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Your Password:" label-for="input-2" description="it's a secret.">
        <b-form-input
          id="input-2"
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
    <hr>
    <b-col><p>Don't have an account? <b-link link to='/register'>Register</b-link></p></b-col>
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
          password: '',
        },
        show: true,
        show_submit: false,
        loading:false,
      }
    },
    methods: {
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.password = ''
      },
                  //login function api
            login:function()
            {
              this.loading = true;
              axios.post('/api/login', {
                'email':this.form.email,
                'password':this.form.password,
              }).then(res => {
                //console.dir(res)
              localStorage.setItem('token',res.data.token);
               localStorage.setItem('loggedIn',true);
              //routing to admin panel
              this.$router.push('/app/home').then(
              ).catch(
                err => console.warn(err)
              );
              })
              .catch(err =>{
        this.loading = false;
        this.$bvToast.toast(`Wrong Details`, {
          title: `${err}`,
          autoHideDelay: 3000,
          appendToast: true
        })
                 });
            }
    },
  }
</script>
