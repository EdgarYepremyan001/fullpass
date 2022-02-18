<template>
  <div>
    <b-container>
      <b-form @submit.prevent="forget">
        <b-form-group
          id="name"
          label="First Name:"
          label-for="name"
        >
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            placeholder="Enter You Email"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="password"
          label="password:"
          label-for="password">
          <b-form-input
            id="password"
            v-model="form.password"
            type="password"
            placeholder="Enter password"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="re_password"
          label="re_password:"
          label-for="re_password">
          <b-form-input
            id="re_password"
            v-model="form.re_password"
            type="text"
            placeholder="Re-Password"
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
  name: "Forget",
  data(){
    return {
      form:{
        email:'',
        password:'',
        re_password:'',
      }
    }
  },
  methods:{
    async forget(){
      await axios.post("http://127.0.0.1:8000/api/forget",this.form).then(response => {
        let user = response.data.user;
        localStorage.setItem('users',JSON.stringify(user));
        localStorage.setItem('access_token',response.data.token);
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');
        alert(response.data.msg);
        this.$router.push("/posts")
      });
    }
  }

}
</script>

<style scoped>

</style>
