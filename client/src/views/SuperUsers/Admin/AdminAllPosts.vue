<template>
  <div>
    <b-container>
      <router-link
        :to="{name: 'Admin'}"
        class="btn btn-primary"
      >Back</router-link>
      <router-link
        class="btn btn-primary"
        :to="{name: 'NewPost'}"
      >Create Post</router-link>
      <h1>Post List</h1>
      <div class="post-list" style="max-height: 950px;overflow-x: hidden;overflow-y: scroll;"
           @scroll="loadMoreEvents($event)">
        <div v-for="post in posts">
          <admin-post-item
            class="post"
            :post="post
        "></admin-post-item>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import AdminPostItem from "../../../components/AdminPostItem";
export default {
  name: "AdminAllPosts",
  components:{
    AdminPostItem,
  },
  mounted(){
    this.$store.dispatch("Posts/getModeratorPosts");
  },
  computed:{
    posts() {
      return this.$store.getters['Posts/getPosts'];
    },
  },
  methods:{
    loadMoreEvents(event) {
      if (event.target.scrollTop + event.target.clientHeight >= event.target.scrollHeight) {
        this.$store.dispatch("Posts/getModeratorPosts")
      }
    },
  }

}
</script>

<style scoped>
.post {
  margin:10px;
}
</style>

