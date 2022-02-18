<template>
  <div>
    <div>
      <b-container>
        <b-form @submit.prevent="login">
          <b-form-group
            id="email"
            label="E-mail:"
            label-for="email"
          >
            <b-form-input
              id="email"
              v-model="form.email"
              type="text"
              placeholder="Enter Your Email"
              required
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="password"
            label="password:"
            label-for="password">
            <b-form-input
              id="surname"
              v-model="form.password"
              type="text"
              placeholder="Enter Password"
              required
            ></b-form-input>

          </b-form-group>
          <router-link :to="{name: 'Forget'}" class="btn btn-outline-primary">Forget Password?</router-link>
          <b-button type="submit" variant="primary">Login</b-button>
        </b-form>
      </b-container>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data(){
    return {
      form:{
        email:'',
        password:'',
      }
    }
  },
  methods:{
    login(){
      this.$store.dispatch("Auth/getAPILogin",this.form)
      .then(() => {
        this.$router.push('posts');
      })
    }
  }
}
</script>

<style scoped>

</style>
