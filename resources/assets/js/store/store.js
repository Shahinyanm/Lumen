import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        teams: [],
        select_teams: [],
        users: [],
    },
    mutations: {
        SET_TEAMS: (state, payload) => {
            state.teams.push(payload);
        },

        SET_SELECT_TEAMS: (state, payload) => {
            state.select_teams.push(payload);
        },
        SET_USERS: (state, payload) => {
            state.users.push(payload);
        },
        EMPTY_TEAMS:(state,payload)=>{
            state.teams=[]
        }
    },
    getters: {
        TEAMS: state => {
            return state.teams;
        },
        SELECT_TEAMS: state => {
            return state.select_teams
        },
        USERS: state=>{
            return state.users
        }
    },
    actions : {
        UPDATE_TEAM : async (context, data) => {

            Vue.http.put('api/teams' + '/' + data.id, {
                title: data.title,
            }).then((response) => {
                let teams = context.getters.TEAMS
                teams.splice(teams.findIndex(function(i){
                    return i.id === data.id;
                }), 1);
                context.commit('SET_TEAMS', response.body);
            }, (error) => {
                console.log(error)
            })
        },
        DELETE_TEAM:(context,id)=>{
            let teams = context.getters.TEAMS
            teams.splice(teams.findIndex(function(i){
                return i.id === id;
            }), 1);

        }

    }
})