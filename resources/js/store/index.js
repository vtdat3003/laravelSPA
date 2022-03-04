import Vuex from 'vuex';
import Vue from 'vue';
import notis from './modules/notis';

Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        notis
    }
})