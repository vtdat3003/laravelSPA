<template>
    <div class="row">
        <form @submit="updateTodo">
            <div class="input-group">
                <input type="text" class="form-control width100" v-model="todo.content" placeholder="Update todo" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </span>
            </div>
        </form>
    </div>
</template>

<script>
export default{
    name: "updateTodo",
    props: ['editedTodo'],
    data: function(){
        return {
            todo: {
                id: this.$props.editedTodo.id,
                content: this.$props.editedTodo.content,
            }
        }
    },
    methods: {
        updateTodo(){
            if (this.todo.content == ""){
                return;
            }
            axios.put('api/todo/' + this.todo.id, {
                todo: this.todo,
                changeStatus: false
            })
            .then(response => {
                if(response.status == 201)
                {
                    this.todo.content = "";
                }
            })
            .catch(error => {
                console.log('error');
            })
        }
    }
}
</script>

<style scoped>

</style>