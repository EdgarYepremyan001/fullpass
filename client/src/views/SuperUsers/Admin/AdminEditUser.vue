<template>
  <div>
    <b-container>
      <h1>Edit {{user.name}}</h1>
      <b-form @submit.prevent="editUser" >
        <b-form-group
          id="title"
          label="Title:"
          label-for="title"
        >
          <b-form-input
            id="name"
            v-model="form.name"
            type="text"
            placeholder="Enter Name"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="email"
          label="Email :"
          label-for="email">
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            placeholder="Enter email"
            required
          ></b-form-input>

        </b-form-group>

        <b-form-group
          id="password"
          label="Password :"
          label-for="password">
          <b-form-input
            id="password"
            v-model="form.password"
            type="password"
            placeholder="Enter password"
            required
          ></b-form-input>

        </b-form-group>

        <b-button type="submit" variant="primary">Save</b-button>
      </b-form>
    </b-container>
  </div>
</template>


<script>
export default {
  name: "AdminEditUser",
  data(){
    return {
      form:{
        name:'',
        email:'',
        password:'',
        role: '',
      }
    }
  },
  mounted(){
    this.$store.dispatch('Users/getAPIUser',this.$route.params.id);
  },
  computed:{
    user(){
      this.form.name = this.$store.getters['Users/getUser']['name'];
      this.form.email = this.$store.getters['Users/getUser']['email'];
      this.form.password = this.$store.getters['Users/getUser']['password'];
      return this.$store.getters['Users/getUser'];
    }
  },
  methods:{
    editUser(){
      axios.put(`http://127.0.0.1:8000/api/admin/${this.$route.params.id}`,this.form).then(response => {
        this.$swal(response.data.msg);
        this.$router.push(`/admin/${this.$route.params.id}`);
      })
    }
  }



}
</script>

<style scoped>

</style>
