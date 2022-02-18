<template>
  <div>
    <div class="admin-post-item headerDiv">
      <div>
        <img :src="post.src" alt="">
      </div>
      <div class="textDiv">
        <h2>{{ post.title }} </h2>
        <div v-html="post.description"> {{ post.description }} </div>
        <router-link :to="{name:'AdminPostsView',params:{id: post.id}}" class="btn btn-primary">View</router-link>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "AdminPostItem",
  data(){
    return {

    }
  },
  props:{
    post:{
      type:Object,
    },
  },
}
</script>

<style scoped>
.headerDiv {
  background-color: black;
  border-radius: 5px;
  text-align: center;
}
h2 {
  color:white;
  margin-top: 15px;
}
img {
  box-shadow: 0 0 12px 12px white, 0 0 3px 2px ghostwhite;
}
p {
  color: black;
  margin-top: 15px;
}
.textDiv {
  align-content: space-between;
  text-align: center;
  max-height: 1000px;
  margin-left:20px;
}
.btn {
  padding:10px 50px 10px 50px;
  font-size: x-large;
}
</style>
