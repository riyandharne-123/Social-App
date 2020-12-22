<template>
 <b-container fluid>
     <b-skeleton-wrapper :loading="loading" style="padding-top:2%;">
     <br>
      <template #loading>
        <b-card>
          <b-skeleton width="85%"></b-skeleton>
          <b-skeleton width="55%"></b-skeleton>
          <b-skeleton width="70%"></b-skeleton>
        </b-card>
        <br>
        <b-card>
          <b-skeleton width="85%"></b-skeleton>
          <b-skeleton width="55%"></b-skeleton>
          <b-skeleton width="70%"></b-skeleton>
        </b-card>
         <br>
        <b-card>
          <b-skeleton width="85%"></b-skeleton>
          <b-skeleton width="55%"></b-skeleton>
          <b-skeleton width="70%"></b-skeleton>
        </b-card>
        <br>
        <b-card>
          <b-skeleton width="85%"></b-skeleton>
          <b-skeleton width="55%"></b-skeleton>
          <b-skeleton width="70%"></b-skeleton>
        </b-card>
        <br>
        <b-card>
          <b-skeleton width="85%"></b-skeleton>
          <b-skeleton width="55%"></b-skeleton>
          <b-skeleton width="70%"></b-skeleton>
        </b-card>
      </template>
    </b-skeleton-wrapper>
   <b-row style="padding-top:4%;">
    <b-col cols="12" v-for="post in posts" :key="post.id">
      <b-card :img-src="post.post_image" img-alt="Card image" img-top>
        <b-card-text>
      <div class="d-flex align-items-center">
        <b-avatar class="mr-3" variant="light" :src="post.profile_image"></b-avatar>
        <span class="mr-auto">
        <h5>{{post.name}}</h5>
        {{post.created_at}}
        </span>
      </div>
        <hr>
        <p v-html="post.post_desc"></p>
        <b-row>
         <b-col>
         <b-badge variant="primary" v-for="tag in JSON.parse(post.post_tags)" :key="tag">
        <h6>{{tag}}</h6>
         </b-badge>
         </b-col>
        </b-row>
        </b-card-text>
        <b-card-text>
        
        <div v-if="post.user_likes != null && post.user_likes.indexOf(`${user_id}`) !== -1">
        <h5>
        <b-icon icon="heart-fill" variant="danger" @click="removelike(post.id)"></b-icon>
        {{post.likes}} likes
        </h5>
        </div>

        <div v-else>
        <h5>
        <b-icon icon="heart" @click="like(post.id)"></b-icon>
        {{post.likes}} likes
        </h5>
        </div>

        </b-card-text>
      </b-card>
    </div>
    <br>
    </b-col>
   </b-row>
 </b-container>
</template>


<script>

  export default {
   data()
   {
    return{
     posts:this.$store.state.user.posts,
     user_id:this.$store.state.user.data.id,
     loading: false,
     loadingTime: 0,
     maxLoadingTime: 1,
    }
   },
       watch: {
      loading(newVal, oldValue) {
        if (newVal !== oldValue) {
          this.clearLoadingTimeInterval()

          if (newVal) {
            this.$_loadingTimeInterval = setInterval(() => {
              this.loadingTime++
            }, 1000)
          }
        }
      },
      loadingTime(newVal, oldValue) {
        if (newVal !== oldValue) {
          if (newVal === this.maxLoadingTime) {
            this.loading = false
          }
        }
      }
    },
   created:function(){
      this.$_loadingTimeInterval = null
     //fetching all posts
    axios.get('/api/posts')
    .then(res =>{
      this.$store.commit("changeUserPosts", res.data.users);
      this.posts = res.data.posts;
    })
    .catch(err => {
     console.log(err)
    })
   },
    mounted() {
      this.startLoading()
    },
   methods:{
    like(post_id){
      axios.post('/api/likes',{
      post_id:post_id
      })
      .then(res =>{
      this.posts = res.data.posts;
      })
    .catch(err => {
     console.log(err)
    })
    },
      removelike(post_id){
      axios.post('/api/removelike',{
      post_id:post_id
      })
      .then(res =>{
      this.posts = res.data.posts;
      })
    .catch(err => {
     console.log(err)
    })
    },
      clearLoadingTimeInterval() {
      clearInterval(this.$_loadingTimeInterval)
      this.$_loadingTimeInterval = null
      },
      startLoading() {
        this.loading = true
        this.loadingTime = 0
      },
   },
  }
</script>
