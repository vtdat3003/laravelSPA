<template>
    <div>
        <div v-for="(todo, index) in todos" :key="index">
            <div v-if="user == todo.user_id">
                <todo v-bind:todo="todo" v-on:refresh="$emit('refresh')"/>
            </div>
        </div>
    </div>
</template>

<script>
import todo from './todo.vue';
export default{
    props: ["todos"],
    components: {
        todo
    },
    data(){
        return{
            user: this.$user,
        }
    }
}
</script>

<style scoped>
.item{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>