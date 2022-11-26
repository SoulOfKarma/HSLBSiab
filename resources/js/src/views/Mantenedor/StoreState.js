import { createApp } from "vue";
import { createStore } from "vuex";
import axios from "axios";
// Create a new store instance.
const store = createStore({
    state() {
        return {
            localVal: process.env.MIX_APP_URL
        };
    },
    getters: {
        TraerBodega() {
            try {
                return axios
                    .get(this.localVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        //this.listaBodega = res.data;
                        //this.listaBodegaL = res.data;
                        commit("SET_CONSTITUENCY", res.data);
                        //return res.data;
                    });
            } catch (error) {
                return console.log(error);
            }
        }
    },
    mutations: {
        /*     increment (state) {
      state.count++
    } */
    }
});

const app = createApp({
    /* your root component */
});

// Install the store instance as a plugin
app.use(store);
