import Vue from "vue";
import VueRouter from "vue-router";
// import Home from "../views/Home.vue";

Vue.use(VueRouter);

import store from "@/store";

const routes = [
  {
    path: "/",
    redirect: {
      name: "dashboard",
    },
    // name: "home",
    // component: Home,
  },
  {
    path: "/login",
    name: "login",
    beforeEnter: (to, from, next) => {
      if (store.getters["auth/isAuthenticated"]) {
        next({ name: "dashboard" });
      } else {
        next();
      }
    },
    component: () => {  return import("../views/Login.vue") },
  },
  {
    path: "/dashboard",
    component: () => { return import("../Layout.vue") },
    // beforeEnter: (to, from, next) => {
    //   if (store.getters["auth/isAuthenticated"]) {
    //     next();
    //   } else {
    //     next({ name: "login" });
    //   }
    // },
    children: [
      {
        path: "",
        name: "dashboard",
        component: () => { return import("../views/Dashboard.vue") },
      },
      {
        path: "collaborators",
        name: "collaborators",
        component: () => {  return import("@/views/Collaborators/index.vue") }
      },
      {
        path: "collaborators/create",
        name: "add collaborator",
        component: () => { return import("@/views/Collaborators/create.vue") }
      },
      {
        path: "collaborators/:id/edit",
        name: "edit collaborator",
        component: () => { return import("@/views/Collaborators/edit.vue") }
      },
      {
        path: "settings",
        name: "settings",
        component: () => { return import("@/views/User/settings.vue") }
      },
      {
        path: "collaborators/:id/profile",
        name: "profile",
        component: () => { return import("@/views/Collaborators/show.vue") }
      },
      {
        path: "collaborators/archive",
        name: "archive",
        component: () => { return import("@/views/Collaborators/archive.vue") }
      }
    ],
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  let loggedIn = store.getters["auth/isAuthenticated"];
  let user = store.getters["auth/user"];
  if(to.name !== "login" && !loggedIn) {
    next({ name: "login" });
  } else if(user) {
    let hasViewPermission = user.permissions.includes('view collaborators');
    if(hasViewPermission || to.name === 'settings') next();
    else if(to.name !== "profile" || to.params.id !== user.id) {
      next({ name: "profile", params: { id: user.id } });
    } else {
      // https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards
      next();
    }
  } else {
    next();
  }
})

export default router;
