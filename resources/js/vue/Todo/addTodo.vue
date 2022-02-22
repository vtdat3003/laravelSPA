<template>
    <div class="row">
        <div class="card bg-light mt-3 p-3 col-md-12">
            <form @submit="addItem">
                <div class="input-group">
                    <input type="text" class="form-control width100" v-model="todo.content" placeholder="Add a todo" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </span>
                </div>
            </form>           
        </div>
    </div>
</template>

<script>
export default{
    name: "addTodo",
    data: function(){
        return {
            todo: {
                content: "",
                user_id: this.$user,
            }
        }
    },
    methods: {
        addItem(){
            if (this.todo.content == ""){
                return;
            }
            axios.post('api/todo/store', {
                todo: this.todo
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