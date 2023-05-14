import Vue from "vue";
import Vuex from "vuex";
import auth from "./auth";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    pageLoading: true,
  },
  getters: {
    isLoading({ state }) {
      return state.pageLoading
    }
  },
  mutations: {
    TOGGLE_LOADING({ state }) {
      state.pageLoading = !state.pageLoading;
    }
  },
  actions: {
    toggleLoader({ commit }) {
      commit('TOGGLE_LOADING');
    },
  },
  modules: {
    auth,
  },
});
