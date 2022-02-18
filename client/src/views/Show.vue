<template>
  <div>
    <router-link
      class="btn btn-primary"
      :to="{name:'Posts'}
    ">Posts</router-link>
    <b-container>
      <h2> {{ post.title }} </h2>
      <img :src="post.src" alt="">
      <div v-html="post.description"> </div>


      <b-button
        @click="deletePost(post.id)"
        variant="danger">Delete</b-button>
      <router-link
        :to="{
        name: 'Edit',
        params:{
          id:post.id,
        }
      }" class="btn btn-success">Edit</router-link>
    </b-container>
  </div>
</template>

<script>
export default {
  name: "Show",
  mounted(){
    this.$store.dispatch('Posts/getAPIPost',this.$route.params.id);
  },
  computed:{
    post(){
      return this.$store.getters['Posts/getPost'];
    }
  },
  methods:{
    deletePost(id){
      this.axios.delete(`http://127.0.0.1:8000/api/posts/${id}`,).then(response => {
        this.$swal(response.data.msg);
        this.$router.push('/posts');
      })
    }
  }
}
</script>

<style scoped>
img{
  width: 500px;
  height: 800px;
  border: 2px solid blue;
}
</style>
