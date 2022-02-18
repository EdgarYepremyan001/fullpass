import axios from "axios";
export default {
  namespaced:true,

  state:{
    posts:[],
    post:[],
  },
  mutations:{
    storePosts:(state,data) => {
      state.posts = data
    },
    storePost:(state,data) => {
      state.post = data
    }
  },
  getters:{
    getPosts: state => state.posts,
    getPost: state => state.post,
  },
  actions:{
    getAPIPosts(context){
      axios.get("http://127.0.0.1:8000/api/posts/",{
        params: {
          skip: context.getters.getPosts.length
        }
      }).then(response => {
        let posts = context.getters.getPosts
        response.data.data.forEach((post) => {
          posts.push(post)
        })
        context.commit('storePosts',posts);
      })
    },
    getModeratorPosts(context){
      axios.get("http://127.0.0.1:8000/api/moderator/posts/", {
        params: {
          skip: context.getters.getPosts.length
        }
      }).then(response => {
        let posts = context.getters.getPosts
          response.data.data.forEach((post) => {
            posts.push(post)
          })
        context.commit('storePosts', posts);
      })
    },
    getAdminPosts(context){
      axios.get("http://127.0.0.1:8000/api/admin/posts/all").then(response => {
        context.commit('storePosts',response.data.data);
      })
    },

    getAPIPost(context,id){
      axios.get(`http://127.0.0.1:8000/api/posts/${id}`).then(response => {
        context.commit('storePost',response.data);
      })
    },
  }
}
