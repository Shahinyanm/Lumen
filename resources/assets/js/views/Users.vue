<template>

</template>

<script>
    // import {logout} from '../mixins/logout'
    export default {
        // mixins: [logout],
        name: "Users",
        data() {
            return {

            }
        },
        beforeCreate:function(){
            if(!localStorage.getItem('token')){
                this.$router.push({ name: "login"});
            }

        },


    }
</script>

<style scoped>

</style>