import apiClient from './api-client';

export default {
    getRolesAndUserRole(size) {
        const promiseRoles = apiClient.get('roles');
        const promiseUserRole = apiClient.get(`users/roles?size=${size}`);
        return Promise.all([promiseRoles, promiseUserRole]);
    },
    getUserRole(page, size) {
        return apiClient.get(`users/roles?page=${page}&size=${size}`);
    },
    postRole(userId, roleId) {
        return apiClient.post(`users/${userId}/roles/${roleId}`);
    },
    deleteRole(userId, roleId) {
        return apiClient.delete(`users/${userId}/roles/${roleId}`);
    },
};
