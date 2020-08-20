import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import newRoute from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks'
import methods from './components/pages/basic/methods'
import useCom from "./vuex/useCom";

//admin project pages

import home from "./components/pages/home"
import tags from "./admin/pages/tags"
import category from "./admin/pages/category"
import adminUsers from "./admin/pages/adminUser"
import login from "./admin/pages/login"
import role from "./admin/pages/role"
import assignRole from "./admin/pages/assignRole"
import createBlog from "./admin/pages/createBlog"
import blogs from "./admin/pages/blogs"
import editblog from "./admin/pages/editblog"
import notfound from "./admin/pages/notfound"


const routes = [
    //project route
    {
        path: "/",
        component: home,
        name: 'home'
    },

    {
        path: "/tags",
        component: tags,
        name: 'tags'
    },
    {
        path: "/adminUsers",
        component: adminUsers,
        name: 'adminUsers'
    },

    {
        path: "/category",
        component: category,
        name: 'category'
    },
    {
        path: "/login",
        component: login,
        name: 'login'
    },
    {
        path: "/role",
        component: role,
        name: 'role'
    },
    {
        path: "/assignRole",
        component: assignRole,
        name: 'assignRole'
    },
    {
        path: "/createBlog",
        component: createBlog,
        name: 'createBlog'
    },
    {
        path: "/blogs",
        component: blogs,
        name: 'blogs'
    },
    {
        path: '/editblog/:id',
        component: editblog,
        name: 'editblog'
    },
    {
        path: '*',
        component: notfound,
        name: 'notfound'
    },

    //basic route

    {
        path: "/testVuex",
        component: useCom
    },

    {
        path: "/newRouter",
        component: newRoute
    },

    //vue hooks

    {
        path: "/hooks",
        component: hooks
    },

    //vue methods

    {
        path: "/methods",
        component: methods
    }
];

export default new Router({
    mode: 'history',
    routes
});


