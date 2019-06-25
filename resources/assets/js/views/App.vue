<template>
    <div>
        <h1></h1>

        <p>

        </p>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link :to="{ name: 'home' }" class="navbar-brand">Home</router-link>
            |
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto" v-if="this.$route.path ==='/login' || this.$route.path ==='/register' ">
                    <li class="nav-item ">
                        <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto" v-else>
<!--                    <li class="nav-item ">-->
<!--                        <router-link :to="{ name: 'users' }"  class="nav-link">Users </router-link>-->
<!--                    </li>-->
                    <li class="nav-item ">
                        <router-link :to="{ name: 'teams' }"  class="nav-link">Teams </router-link>
                    </li>
                    <li class="nav-item ">
                        <a href="javascript:;" class="nav-link" @click="logout">Logout </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import {mixins} from '../mixins/mixins';
    import {logout} from '../mixins/logout';

    export default {
        mixin: [mixins, logout],
        data() {
            return {
                authenticated: false,
                name: '',

            }
        },
        methods: {
            logout: function () {
                this.$http.post('api/logout').then(
                    response => {
                        console.log(response.body.status)
                        if (response.body.status === 1) {
                            localStorage.removeItem('token');
                            this.logged = false
                            this.$router.push('/login');
                        }
                    },
                    response => {
                        if (response.status === 401) {
                            this.$router.push('/');
                        }

                        // this.$router.push('/');
                    }
                );
            },
        },

    }
</script>