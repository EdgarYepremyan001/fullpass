export default {
  namespaced:true,
  state:{
    users: localStorage.getItem('users')? JSON.parse(localStorage.getItem('users')) : [],
  },
  mutations:{
    storeUser:(state,data)=>{
      state.user = data;
    }
  },
  getters:{
    getUsers: state => state.user,
  },
  actions:{
    async getAPILogin(context,data){
      let user = context.state.user;
        await axios.post("http://127.0.0.1:8000/api/login",data).then(response => {
        user = response.data.user;
        localStorage.setItem("users",JSON.stringify(user));
        localStorage.setItem("access_token",response.data.token);
        localStorage.setItem("roles",JSON.stringify(response.data.roles));
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');
        context.commit("storeUser");
        alert(response.data.msg);

        })
    }


  }
}


