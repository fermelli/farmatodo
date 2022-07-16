import apiClient from './api-client';

export default {
    getProducts(page, size) {
        return apiClient.get(`products-paginate?page=${page}&size=${size}`);
    },
};
