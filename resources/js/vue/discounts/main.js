import { createApp } from 'vue';
import productService from './../../services/product-service';
import PaginationButtons from './../components/PaginationButtons.vue';
import MiniCardProduct from './MiniCardProduct.vue';

createApp({
    components: {
        PaginationButtons,
        MiniCardProduct,
    },
    data() {
        return {
            loading: false,
            size: parseInt(localStorage.getItem('sizeForDiscount')) || 20,
            productsPagination: null,
            productsIds:
                JSON.parse(localStorage.getItem('productsWithDiscount')) || [],
        };
    },
    created() {
        this.getProducts();
    },
    methods: {
        async getProducts(page) {
            page = page || 1;
            try {
                this.loading = true;
                const promiseProducts = await productService.getProducts(
                    page,
                    this.size
                );
                this.productsPagination = promiseProducts.data;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        changeSizePagination(size) {
            this.size = size;
            localStorage.setItem('sizeForDiscount', String(this.size));
            this.getProducts(1);
        },
        addProductId(id) {
            let index = this.productsIds.indexOf(id);
            if (index != -1) {
                this.productsIds.splice(index, 1);
            } else {
                this.productsIds.push(id);
            }
            localStorage.setItem(
                'productsWithDiscount',
                JSON.stringify(this.productsIds)
            );
        },
        resetLocalStorage() {
            localStorage.setItem('productsWithDiscount', JSON.stringify([]));
        },
    },
}).mount('#root-discounts');
