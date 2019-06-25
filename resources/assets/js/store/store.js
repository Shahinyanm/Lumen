import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        teams: []
    },
    mutations: {
        getTeam(state) {
            this.$http.get('api/teams').then((response) => {
                response.body.map(function (value, key) {

                    state.teams.push(value);
                });
            }, () => {

            })
        },

    }
})