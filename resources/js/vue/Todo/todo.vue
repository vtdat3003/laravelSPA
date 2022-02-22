<template>
    <div class="row">
        <div class="card bg-light mt-3 col-md-8">
            <div class="card-body">
                <div v-if="editing">
                    <update-todo v-bind:editedTodo="todo"/>
                </div>
                <div v-else>
                    <h5 class="card-text" v-bind:style="todo.status == 'done'? 'text-decoration: line-through;' : '' ">{{todo.content}}</h5>
                </div>
            </div>
        </div>
        <div class="card bg-light mt-3 col-md-4">
            <div class="card-body text-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary" @click="taskDone">Mark as done</button>
                    <button type="button" class="btn btn-primary" @click="editTodo">Update</button>
                    <button type="button" class="btn btn-danger" @click="deleteTodo">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import updateTodo from './updateTodo.vue';
export default{
    components: {
        updateTodo
    },
    props: ['todo'],
    data(){
        return {
            editing: false,
        }
    },
    methods: {
        deleteTodo(){
            axios.delete('api/todo/' + this.todo.id)
            .then(response => {
                if(response.status == 200){
                    this.$emit('itemchanged');
                }
            })
            .catch(error => {
                console.log(error);
            })
            this.$emit('refresh');
        },
        taskDone(){
            axios.put('api/todo/ ' + this.todo.id, {
                todo: this.todo,
                changeStatus: true
            })
            .then(response => {
                if(response.status == 201){
                    this.$emit('itemchanged');
                    location.reload();
                }
            })
            .catch(error => {
                console.log(error);
            })
            this.$emit('refresh');
        },
        editTodo(){
            this.editing = true;
        }
    }
}
</script>

<style scoped>

</style>