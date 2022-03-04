import { response } from '@websanova/vue-auth/drivers/auth/bearer';
import axios from 'axios';

const state = {
    notis: []
};

const getters = {
    allNotis: state => state.notis
};

const actions = {
    async fetchNotis({commit}){
        const response = await axios.get('api/notis');
        commit('setNotis', response.data);
    },
    async deleteNoti({commit},id){
        await axios.delete('api/noti/' + id);
        commit('removeNoti', id);
    },
    async addNoti ({commit},noti){
        const response = await axios.post('api/noti/store', noti);
        commit('newNoti', response.data);
    }
};

const mutations = {
    setNotis: (state, notis) => (state.notis = notis),
    removeNoti: (state, id) => state.notis = state.notis.filter(noti => noti.id !== id),
    newNoti: (state, noti) => state.notis.unshift(noti),
};

export default {
    state,
    getters,
    actions,
    mutations
}