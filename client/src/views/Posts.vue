<template>
  <div>

    <b-container>
      <button class="btn btn-primary" @click="logout">Logout</button>
      <router-link
        v-if="isAdmin"
        :to="{name: 'Admin'}"
        class="btn btn-success"
      >Admin Page</router-link>
      <router-link
        v-if="isModerator"
        :to="{name: 'Moderator'}"
        class="btn btn-success"
      >Moderator Page</router-link>
      <router-link
        class="btn btn-primary"
        :to="{name: 'NewPost'}"
      >Create Post</router-link>
      <div class="post-list gallery" style="max-height: 950px;overflow-x: hidden;overflow-y: scroll;" @scroll="loadMoreEvents($event)">
        <div class="post-list" v-for="(post, key) in posts">
          <post-item
            class="post"
            :post="post
          "><h2>{{key+1}}</h2></post-item>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import PostItem from "../components/PostItem";
export default {
  name: "Posts",
  components:{
    PostItem,
  },
  data(){
    return {
      isAdmin: false,
      isModerator: false,
    }
  },
  mounted(){
    this.checkAdmin();
    this.checkModerator();
    this.$store.dispatch("Posts/getAPIPosts");
  },
  computed:{
    posts() {
      return this.$store.getters['Posts/getPosts'];
    },
  },
  methods:{
    logout(){
      axios.post('http://127.0.0.1:8000/api/logout').then(response => {
        this.$router.push("/")
        localStorage.removeItem('access_token');
        localStorage.removeItem('users');
        localStorage.removeItem('roles');
      });
    },
    checkAdmin(){
      let roles = JSON.parse(localStorage.getItem("roles"));
      if(roles && Object.values(roles).length && roles[0].name === 'admin'){
        this.isAdmin = true;
      }
    },
    checkModerator(){
      let roles = JSON.parse(localStorage.getItem("roles"));
      if(roles && Object.values(roles).length && roles[0].name === 'moderator'){
        this.isModerator = true;
      }
    },
    loadMoreEvents(event) {
      if (event.target.scrollTop + event.target.clientHeight >= event.target.scrollHeight) {
        this.$store.dispatch("Posts/getAPIPosts")
      }
    },
  }
}
</script>

<style scoped>
.post {
  margin:10px;
}
img {
  width: 100px;
  height: 100px;
}
</style>
