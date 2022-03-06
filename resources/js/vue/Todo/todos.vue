<template>
    <div>
        <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg4 v-for="(todo, index) in todos" :key="index">
            <todo v-bind:todo="todo" v-on:refresh="$emit('refresh')"/>
        </v-flex>
        </v-layout>
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