import auth from '../middleaware/auth'
import Login from '../views/Login'
import Register from '../views/Register'
import Home from '../views/Home'
import PageNotFound from '../views/PageNotFound'
// import Users from '../views/Users'
import Teams from '../views/Teams'

export default [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            middleware: auth,
        },
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },

    {
        path: '/register',
        name: 'register',
        component: Register,
    },

    {
        path: '*',
        component: PageNotFound,

    },

    {
        path: '/teams',
        name: 'teams',
        component: Teams,
        meta: {
            middleware: [auth],
        },
    },


    // Creates a `nextMiddleware()` function which not only
    // runs the default `next()` callback but also triggers
    // the subsequent Middleware function.


];

