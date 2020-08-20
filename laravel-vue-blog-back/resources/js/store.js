import Vue from "vue";
import Vuex from 'vuex'

Vue.use(Vuex)


export default new Vuex.Store({
    state: {
        counter: 100,
        deleteModalObject: {
            showDeleteModal: false,
            deleteUrl: "",
            data: null,
            deletingIndex: -1,
            isDeleted: false
        },
        user:false,
        userPermission:null,
    },
    getters: {
        getCounter(state) {
            return state.counter;
        },
        getDeleteModalObj(state) {
            return state.deleteModalObject;
        },
        getUserPermission(state) {
            return state.userPermission;
        },
    },
    mutations: {
        changeTheCounter(state, data) {
            state.counter += data;
        },
        setDeleteModal(state, data) {
            const deleteModalObject = {
                showDeleteModal: false,
                deleteUrl: "",
                data: null,
                deletingIndex: -1,
                isDeleted: data
            };
            state.deleteModalObject = deleteModalObject;
        },
        setDeletingModalobj(state, data) {
            state.deleteModalObject = data;
        },
        setUpdateUser(state, data) {
            state.user = data;
        },
        setUserPermission(state, data) {
            state.userPermission = data;
        },
    },
    actions: {
        changeCounterAction({ commit }, data) {
            commit("changeTheCounter", data);
        }
    }
});









