<template>
    <div clas="container">
        <h5>Your account has been deactivated</h5>
        <a @click="submit">Login again</a>
    </div>
</template>

<script>
export default({
    data(){
        return{
            user: this.$user
        }
    },
    methods:{
        submit: function()
        {
            document.cookie = 'authorize=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            axios.post('api/auth/logout', {
                user: this.$user
            }).then(response => { 
                window.location.href = "/login";
            })
            .catch(error => {
                console.log(error);
            });
        },
    },
})
</script>
