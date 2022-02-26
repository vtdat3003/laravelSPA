<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                        <a class="nav-link active" href="/users">Users</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="/">Todos
                        </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" 
                                @click="submit">
                                Logout
                            </a>
                            <!-- <a class="nav-link me-auto" href="#" @click.prevent="$auth.logout()">Logout</a> -->
                        </li>
                    </ul>
                </div>
            </div>
        </nav> 
    </div>
</template>

<script>
export default{
    data(){
        return{
            user: this.$user,
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
        }
    }
}
</script>

<style scoped>

</style>