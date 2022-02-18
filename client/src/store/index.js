import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import Auth from "./modules/Auth";
import Users from "./modules/Users";
import Posts from "./modules/Posts";

Vue.use(Vuex)

const store = new Vuex.Store({
  modules:{
    Auth,
    Posts,
    Users,
  }
})
export default store
