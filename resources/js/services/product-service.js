import apiClient from './api-client';

export default {
    getProducts(page) {
        return apiClient.get(`products-paginate?page=${page}`);
    },
};
