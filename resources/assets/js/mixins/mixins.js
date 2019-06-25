
export const mixins = {
    data() {
        return {

        }

    },
    beforeCreate:function(){
        if(localStorage.getItem('token')){
            console.log(localStorage.getItem('token'))
        }

    },

    mounted:function(){
        // console.log(this.fingerprints);
        // console.log(this.fbCookies);
        // console.log(this.timezone);
        // console.log(this.geolocation);
    },


}