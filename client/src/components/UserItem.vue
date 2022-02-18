<template>
    <div class="d-flex">
      <div class="user-item headerDiv">
        <h2>{{ user.id }}. {{ user.name }}</h2>
        <p> {{ user.email }} </p>
        <div>
          <router-link :to="{name:'AdminShowUser', params:{id: user.id}}" class="btn btn-success">View</router-link>
          <router-link class="btn btn-primary" :to="{name: 'AdminPostsView',params:{id:user.id}}">Posts</router-link>
        </div>
      </div>

    </div>
</template>

<script>
export default {
  name: "UserItem",
  data(){
    return {

    }
  },
  props:{
    user:{
      type:Object,
    }
  }
}
</script>

<style scoped>
.headerDiv {
  background-image: linear-gradient(white,black);
  border: 2px solid blue;
  border-radius: 5px;
  height: 140px;
  width: 1320px;
  box-shadow: 0 0 40px 17px blue, 0 0 9px -46px darkblue;;
  margin-top:20px;
  color:black;

}
</style>
