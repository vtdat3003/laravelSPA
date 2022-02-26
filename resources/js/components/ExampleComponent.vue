<template>
    <div>
        <navbar />
        <div class="container">
            <addTodo />
            <todos v-bind:todos="todos" v-on:refresh="getTodos"/>
        </div>
    </div>
</template>

<script>
import todos from '../vue/Todo/todos.vue';
import addTodo from '../vue/Todo/addTodo.vue';
import navbar from '../vue/navbar.vue';

export default{
    components: {
        todos,
        addTodo,
        navbar
    },
    data: function(){
        return {
            todos: []
        }
    },
    methods: {
        getTodos(){
            axios.get('api/todos')
            .then(response => {
                this.todos = response.data
            })
            .catch(error => {
                //console.log('error');
            })
        }
    },
    created(){
        this.getTodos();
    },
}
</script>

<style scoped>

</style>