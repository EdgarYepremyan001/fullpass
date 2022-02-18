<template>
  <div>
    <b-container>
      <router-link :to="{name: 'Posts'}" class="btn btn-primary">Back</router-link>
      <router-link :to="{name: 'AdminAllPosts'}" class="btn btn-primary">All Posts</router-link>
      <router-link :to="{name: 'AdminNewUser'}" class="btn btn-success">New User</router-link>
      <div class="user-list" v-for="user in users">
        <user-item
          :user="user
        "></user-item>
      </div>

    </b-container>
  </div>
</template>

<script>
import UserItem from "../../../components/UserItem";
export default {
  name: "Admin",
  components:{
    UserItem,
  },
  mounted(){
    this.$store.dispatch('Users/getAPIUsers');
  },
  computed: {
    users(){
      return this.$store.getters['Users/getUsers'];
    }
  },

}
</script>

<style scoped>

</style>
