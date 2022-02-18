import axios from "axios";
export default {
  namespaced:true,

  state:{
    users:[],
    user:[],
  },
  mutations:{
    storeUsers:(state,data) => {
      state.users = data
    },
    storeUser:(state,data) => {
      state.user = data
    }
  },
  getters:{
    getUsers: state => state.users,
    getUser: state => state.user,
  },
  actions:{
    getAPIUsers(context){
      axios.get("http://127.0.0.1:8000/api/admin").then(response => {
        context.commit('storeUsers',response.data);
      })
    },

    getAPIUser(context,id){
      axios.get(`http://127.0.0.1:8000/api/admin/${id}`).then(response => {
        context.commit('storeUser',response.data);
      })
    }
  }
}

