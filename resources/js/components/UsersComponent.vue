<template>
    <div>
        <navbar />
        <div class="container">
            <table class="table table-striped sm-3 mt-3">
                <tr class="bg-light">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                    <tr v-for="(user, index) in users" :key="index">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}
                            <span class="badge rounded-pill bg-primary text-white" v-if="user.role == 'admin'">admin</span>
                            <span class="badge rounded-pill bg-warning text-white" v-if="user.active == false">deactivated</span>
                        </td>
                        <td>{{user.email}}</td>
                        <td>
                            <div v-if="user.role != 'admin'">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" @click="updateUser(user.id)">
                                        <span v-if="user.active == false">Activate</span>
                                        <span v-else>Deactivate</span>
                                    </button>
                                    <button type="button" class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
                                </div>
                            </div>
                        </td>
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
        },
        updateUser(id){
            axios.post('api/user/' + id)
            .then(response => {
                
            })
            .catch(error => {
                console.log(error);
            })
            this.getUsers();
        },
        deleteUser(id){
            axios.delete('api/user/' + id)
            .then(response => {
                this.getUsers();
            })
            .catch(error => {
                console.log(error);
            })
            this.getUsers();
        }
    },
    created(){
        this.getUsers();
    }
}
</script>

<style scoped>

</style>