<template>
        <v-card class="text-xs-center ma-3" width="100%">
            <v-card-text>
                <div v-if="editing">
                    <update-todo v-bind:editedTodo="todo" v-on:refresh="$emit('refresh')"/>
                </div>
                <div v-else>
                    <h4 
                    class="d-inline-block text-truncate" 
                    style="max-width: 250px;" 
                    v-bind:style="todo.status == 'done'? 'text-decoration: line-through;' : '' ">
                        {{todo.content}}
                    </h4>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-flex class="justify-end">
                    <v-btn color="info" small tile outlined @click="taskDone">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                        </svg>
                    </v-btn>
                    <v-btn color="info" small tile outlined  @click="editTodo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg>
                    </v-btn>
                    <v-btn color="red" small tile outlined @click="deleteTodo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </v-btn>             
                </v-flex>
            </v-card-actions>
        </v-card>
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