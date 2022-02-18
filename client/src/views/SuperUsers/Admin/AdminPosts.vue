<template>
  <div>
    <b-container>
      <router-link
        class="btn btn-primary"
        :to="{name: 'NewPost'}"
      >Create Post</router-link>
      <h1>Post List</h1>
      <div class="post-list" v-for="post in posts">
        <admin-post-item
          :post="post
        "></admin-post-item>
      </div>
    </b-container>
  </div>
</template>

<script>
import AdminPostItem from "../../../components/PostItem";
export default {
  name: "AdminPosts",
  components:{
    AdminPostItem,
  },
  mounted(){
    this.$store.dispatch("Posts/getAdminPosts");
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
