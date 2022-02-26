<template>
    <div>
        <navbar />
        <div class="container">
            <table class="table table-striped sm-3 mt-3">
                <tr class="bg-light">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created_at</th>
                </tr>
                    <tr v-for="(user, index) in users" :key="index">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}<span class="badge rounded-pill bg-primary text-white" v-if="user.role == 'admin'">admin</span></td>
                        <td>{{user.email}}</td>
                        <td>{{user.created_at}}</td>
                    </tr>
            </table>
        </div>
    </div>
</template>

<script>
import navbar from '../vue/navbar.vue';
export default {
    components:{
        navbar
    },
    data(){
        return{
            users: []
        }
    },
    methods:{
        getUsers(){
           axios.get('api/users')
            .then(response => {
                this.users = response.data
            })
            .catch(error => {
                console.log('error');
            }) 
        }
    },
    created(){
        this.getUsers();
    }
}
</script>

<style scoped>

</style>