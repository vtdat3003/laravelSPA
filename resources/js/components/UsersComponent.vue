<template>
    <v-app>
        <v-main class="yellow lighten-4">
            <navbar />
            <v-container class="ma-3">
                <v-layout row wrap>
                    <v-flex xs12 sm12 md6 lg4 v-for="(user, index) in users" :key="index">
                        <v-card class="text-xs-center ma-3" width="100%">
                            <v-responsive class="pt-4">
                                <v-avatar class="ml-4">
                                    <img :src="'/images/' + user.avatar" />
                                </v-avatar>
                            </v-responsive>
                            <v-card-text>
                                <h4>{{user.name}}</h4>
                                <v-flex class="justify-end">
                                <span v-if="user.role == 'admin'">
                                    <v-chip x-small>admin</v-chip>
                                </span>
                                <span v-if="!user.active">
                                    <v-chip x-small color="red" text-color="white">Deactivated</v-chip>
                                </span>
                                <span v-else>
                                    <v-chip color="white"></v-chip>
                                </span>
                                </v-flex>
                            </v-card-text>
                            <v-card-actions>
                                <v-flex class="justify-end">
                                    <v-btn color="info" small depressed tile outlined  @click="updateUser(user.id)">
                                        <span v-if="user.active == false">Activate</span>
                                        <span v-else>Deactivate</span>
                                    </v-btn>
                                    <v-btn color="red" small depressed tile outlined @click="deleteUser(user.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </v-btn>             
                                </v-flex>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
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