import Login from '../views/Login'
import Register from '../views/Register'
import Home from '../views/Home'
import Users from '../views/Users'
import Teams from '../views/Teams'

export default [
    {
        path: '/',
        name: 'home',
        component: Home
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
        path: '/users',
        name: 'users',
        component: Users,
    },
    {
        path: '/teams',
        name: 'teams',
        component: Teams,
    }

];