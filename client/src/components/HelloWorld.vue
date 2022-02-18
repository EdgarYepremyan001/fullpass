<template>
  <div>
    <div v-if="!islogined">
      <router-link
        class="btn btn-primary"
        :to="{name: 'Login'}"
      >Login</router-link>
      <b-container>
        <b-form @submit.prevent="register">
          <b-form-group
            id="name"
            label="First Name:"
            label-for="name"
          >
            <b-form-input
              id="name"
              v-model="form.name"
              type="text"
              placeholder="Enter First Name"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="email"
            label="E-mail:"
            label-for="email">
            <b-form-input
              id="email"
              v-model="form.email"
              type="email"
              placeholder="Enter E-mail"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="password"
            label="Password:"
            label-for="password">
            <b-form-input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="******************"
              required
            ></b-form-input>
          </b-form-group>
          <b-button type="submit" variant="primary">Register</b-button>
        </b-form>
      </b-container>
    </div>
    <div v-if="islogined">
      <b-container>
        <h2>You are already Logined</h2>
        <p>Send button for go to Home page</p>
        <router-link :to="{name:'Posts'}" class="btn btn-primary">Home</router-link>
      </b-container>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HelloWorld',
  data(){
    return {
      islogined:false,
      form:{
        name:'',
        email:'',
        password:'',
      },
    }
  },
  mounted(){
    this.checkLogin();
  },
  methods:{
    async register(){
      await axios.post("http://127.0.0.1:8000/api/register", this.form).then(response => {
        let user = response.data.user;
        localStorage.setItem('users',JSON.stringify(user));
        localStorage.setItem('access_token',response.data.token);
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');
        this.$router.push("posts");
        this.$swal(response.data.msg);
      })
    },
    checkLogin(){
      let user = JSON.parse(localStorage.getItem("users"))
      console.log(user)
      if(user !== null){
        this.islogined = true;
      }
    }
  }
}
</script>

<style scoped>

</style>
