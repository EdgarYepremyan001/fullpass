<template>
  <div>
    <router-link :to="{name: 'Admin'}" class="btn btn-primary">Back</router-link>
    <b-container>
      <h2>{{ user.name }}</h2>
      <p>{{ user.email }}</p>
      <p>{{ user.password }}</p>
      <b-button
        @click="deleteUser(user.id)"
        variant="danger">Delete
      </b-button>
      <router-link :to="{name: 'AdminEditUser', params:{ id:user.id, }}" class="btn btn-primary">Edit User</router-link>

    </b-container>
  </div>
</template>

<script>
export default {
  name: "AdminShowUser",
  mounted() {
    this.$store.dispatch('Users/getAPIUser', this.$route.params.id);
  },
  computed: {
    user() {
      return this.$store.getters['Users/getUser'];

    }
  },
  methods: {
    deleteUser(id) {
      axios.delete(`http://127.0.0.1:8000/api/admin/${id}`,).then(response => {
        this.$swal(response.data.msg);
        this.$router.push('/admin');
      })
    }
  }
}
</script>

<style scoped>

</style>
