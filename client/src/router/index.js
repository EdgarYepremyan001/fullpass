import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import Login from "../views/Auth/Login";
import Posts from "../views/Posts";
import NewPost from "../views/NewPost";
import Show from "../views/Show";
import Edit from "../views/Edit";
import Admin from "../views/SuperUsers/Admin/Admin";
import AdminShowUser from "../views/SuperUsers/Admin/AdminShowUser";
import AdminEditUser from "../views/SuperUsers/Admin/AdminEditUser";
import AdminNewUser from "../views/SuperUsers/Admin/AdminNewUser";
import AdminPostsView from "../views/SuperUsers/Admin/AdminPostsView";
import Moderator from "../views/SuperUsers/Moderator/Moderator";
import AdminPosts from "../views/SuperUsers/Admin/AdminPosts";
import admin from "../middleware/admin";
import moderator from "../middleware/moderator";
import Forget from "../views/Auth/Forget";
import AdminEditPosts from "../views/SuperUsers/Admin/AdminEditPosts";
import AdminAllPosts from "../views/SuperUsers/Admin/AdminAllPosts";


Vue.use(Router)

export default new Router({
  mode:"history",
  routes: [
    { path: '/',name: 'HelloWorld',component: HelloWorld },
    { path: '/forget',name: 'Forget',component: Forget },
    { path: '/login',name: 'Login',component: Login },
    { path: '/posts',name: 'Posts',component: Posts},
    { path: '/posts/new',name: 'NewPost',component: NewPost },
    { path: '/posts/:id',name: 'Show',component: Show },
    { path: '/posts/:id/edit',name: 'Edit',component: Edit },
    { path: '/admin',name: 'Admin',component: Admin,meta:{middleware:admin}},
    { path: '/admin/posts',name: 'AdminAllPosts',component: AdminAllPosts,meta:{middleware:admin}},
    { path: '/admin/:id', name: 'AdminShowUser', component: AdminShowUser ,meta:{middleware:admin}},
    { path: '/admin/:id/edit',name: 'AdminEditUser',component: AdminEditUser ,meta:{middleware:admin}},
    { path: '/admin/new',name: 'AdminNewUser',component: AdminNewUser ,meta:{middleware:admin}},
    { path: '/admin/:id/posts',name: 'AdminPostsView',component: AdminPostsView ,meta:{middleware:admin}},
    { path: '/admin/:id/posts/edit',name: 'AdminEditPosts',component: AdminEditPosts ,meta:{middleware:admin}},
    { path: '/admin/posts/all',name: 'AdminPosts',component: AdminPosts ,meta:{middleware:admin}},
    { path: '/moderator',name: 'Moderator',component: Moderator, meta:{middleware:moderator}},
  ]
})
