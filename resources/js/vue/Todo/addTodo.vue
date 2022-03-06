<template>
    <div>
        <v-container class="my-2">
            <v-form>
                <v-row>
                    <v-text-field
                        v-model="todo.content"
                        label="Add a todo"
                        required
                    ></v-text-field>
                    <v-btn @click="addItem" class="mx-2" height="50px">Submit</v-btn>
                </v-row>
            </v-form>
        </v-container>
    </div>
</template>

<script>
export default{
    name: "addTodo",
    data: function(){
        return {
            todo: {
                content: "",
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
                    console.log('here');
                    this.$emit('refresh');
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