<template>
    <div class="container">
        <addTodo />
        <todos v-bind:todos="todos"/>
    </div>
</template>

<script>
import todos from '../vue/todos.vue';
import addTodo from '../vue/addTodo.vue';
export default{
    components: {
        todos,
        addTodo
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
                console.log('error');
            })
        }
    },
    created(){
        this.getTodos();
    }
}
</script>

<style scoped>

</style>