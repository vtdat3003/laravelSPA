<template>
    <div>
        <navbar />
        <div class="container">
            <ol class="breadcrumb mt-3 p-3 col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control width100" v-model="noti.content" placeholder="Notify a user" />
                </div>
                <div class="input-group">
                    <select class="form-control width100 mt-1" v-model="noti.user_id" required>
                        <option value="">--SELECT USER--</option>
                        <option v-for="user in users" v-bind:key="user.id" v-bind:value="user.id">
                            {{user.name}}
                        </option>
                    </select>
                </div>
                <div class="input-group-btn mt-1">
                    <button @click="onSubmit" type="submit" class="btn btn-primary">Submit</button>
                </div>           
            </ol>
            <div v-for="noti in allNotis" v-bind:key="noti.id">
                <ol class="breadcrumb mt-3 p-1 d-flex justify-content-end">
                    <div class="mr-auto p-2">{{noti.content}}</div>
                    <span class="mb-0 mr-auto p-2">
                        <small>{{noti.created_at}}</small>
                    </span>
                    <div v-if="role == 'admin'" class="text-right p-2">
                        <small v-if="role =='admin' ">User ID:{{noti.user_id}}</small>
                    </div>
                    <div @click="deleteNoti(noti.id)" v-else class="btn btn-danger text-right p-2">Delete</div>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
import navbar from '../vue/navbar.vue';
import { mapGetters, mapActions } from 'vuex';
export default{
    name: 'Notis',
    data(){
        return{
            role: '',
            users: [],
            noti: {
                content: "",
                user_id: 0
            }
        }
    },
    components: {
        navbar
    },
    methods: {
        ...mapActions(['fetchNotis', 'deleteNoti', 'addNoti']),
        getRole: function()
        {
            axios.post('api/getRole', {
                id: this.$user
            }).then(response => {
                this.role = response.data
            })
            .catch(error => {
                console.log(error);
            })
        },
        getUsers(){
           axios.get('api/users')
            .then(response => {
                this.users = response.data
            })
            .catch(error => {
                console.log('error');
            }) 
        },
        onSubmit(e){
            if(this.noti.user_id == '')
            {
                return;
            }
            e.preventDefault();
            this.addNoti(this.noti);
        }
    },
    computed: mapGetters(['allNotis']),
    created(){
        this.fetchNotis();
        this.getRole();
        this.getUsers();
    }
}
</script>

<style scoped>

</style>