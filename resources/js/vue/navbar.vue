<template>
    <div>
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </v-app-bar-nav-icon>
            <v-app-bar-title class="text-no-wrap">
                <span class="font-weight-light">TODO</span>
            </v-app-bar-title>
            <v-spacer></v-spacer>
            <v-menu
                open-on-hover
                top
                offset-y
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                    color="info"
                    dark
                    v-bind="attrs"
                    v-on="on"
                    >
                    Actions
                    <v-icon></v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item @click="submit">
                    <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        <v-navigation-drawer app v-model="drawer">
            <v-card
                class="mx-auto"
                max-width="300"
                tile
            >
                <v-list >
                <v-subheader>REPORTS</v-subheader>
                <v-list-item-group
                    color="primary"
                >       
                    <v-list-item
                    v-for="(link, i) in links"
                    :key="i" v-bind:href="link.route"
                    >
                    
                        <v-list-item-content>
                            <v-list-item-title v-text="link.text"></v-list-item-title>
                        </v-list-item-content>
                    
                    </v-list-item>
                </v-list-item-group>
                </v-list>
            </v-card>
        </v-navigation-drawer>
    </div>
</template>

<script>
export default{
    data(){
        return{
            user: this.$user,
            role: '',
            drawer:false,
            links: [
                {text: 'Home', route: '/home'},
                {text: 'Users', route: '/users'},
                {text: 'Todos', route: '/todos'},
                {text: 'Notifications', route:'/notis'},
            ]
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
        }
    },
    created(){
        this.getRole()
    },
}
</script>

<style scoped>
.v-app-bar-title__content{
  width: 200px !important;
}

</style>