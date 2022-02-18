<template>
  <div>
    <b-container>
      <router-link
        class="btn btn-primary"
        :to="{name: 'NewPost'}"
      >Create Post</router-link>
      <h1>Post List</h1>
      <div class="post-list" v-for="post in posts">
        <post-item
          :post="post
        "></post-item>
      </div>
    </b-container>
  </div>
</template>

<script>
import PostItem from "../../../components/PostItem";
export default {
  name: "Moderator",
  components:{
    PostItem,
  },
  mounted(){
    this.$store.dispatch("Posts/getModeratorPosts");
  },
  computed:{
    posts() {
      return this.$store.getters['Posts/getPosts'];
    }
  }
}
</script>

<style scoped>

</style>
