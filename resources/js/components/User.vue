<template>
<b-container fluid>
  <b-row style="padding-top:4%;">
   <b-col align="center">
    <b-spinner variant="primary" label="Spinning" v-if="user_loading"></b-spinner>
    <div class="mt-4">
    <b-card no-body class="overflow-hidden" style="max-width: 540px;">
    <b-row no-gutters>
      <b-col md="6">
        <b-card-img :src="user_data.profile_image" alt="Image" class="rounded-0"></b-card-img>
      </b-col>
      <b-col md="6">
        <b-card-body :title="user_data.name">
          <b-card-text>
           <p v-html="user_data.description"></p>
           <hr>
           <h5>Following: {{user_data.following}}  Followers: {{user_data.followers}}</h5>
          </b-card-text>
        </b-card-body>
      </b-col>
    </b-row>
  </b-card>
  </div>
   </b-col>
  </b-row>
</b-container>
</template>

<script>
export default {
  data(){
    return{
     user_id:this.$route.params.id,
     user_data:null,
     user_loading:false,
    }
  },
  created(){
    this.user_loading = true
     axios.get(`/api/users/${this.user_id}`)
    .then(res =>{
     this.user_data = res.data.user
     this.user_loading = false
    })
    .catch(err => {
     console.log(err)
    })
  }
}
</script>