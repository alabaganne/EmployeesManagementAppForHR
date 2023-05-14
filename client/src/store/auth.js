import axios from "axios";

export default {
  namespaced: true,
  state: {
    user: null,
    token: null,
  },

  getters: {
    isAuthenticated(state) {
      return state.token !== null; // returns true if a user is logged in
    },
    user(state) {
      return state.user;
    },
  },

  mutations: {
    SET_TOKEN(state, token) {
      state.token = token;
    },
    SET_USER(state, user) {
      if(!user) {
        state.user = null
        return;
      }
      state.user = user;
    },
  },

  actions: {
    attempt({ commit }, token) {
      if (!token) {
        return; // there's no point of sending a token to retrieve the user info if token is null
      }
      return new Promise((resolve, reject) => {
        axios
          .get("/auth/me", {
            headers: {
              Authorization: "Bearer " + token,
            },
          }).then(response => {
            commit("SET_TOKEN", token);
            axios.defaults.headers["Authorization"] = `Bearer ${token}`;
            commit("SET_USER", response.data.data);
            resolve(response);
          }).catch(error => {
            if (error.response.status === 401) {
              commit("SET_TOKEN", null);
              localStorage.removeItem("token");
            }
            reject(error);
          });
      });
    },

    logout({ commit, state }) {
      if(state.token) {
        return new Promise(resolve => {
          axios.post("/auth/logout").then(() => {
            commit("SET_TOKEN", null);
            commit("SET_USER", null);
            resolve();
          }).catch(error => {
            console.log(error);
          });
        })
      }
    },

    refreshToken() {
      // 
    },
    updateUser({ commit }, user) {
      commit('SET_USER', user);
    }
  },
};
