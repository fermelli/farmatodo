import { createApp } from 'vue';
import FieldFormPurchase from './FieldFormPurchase.vue';

createApp({
    components: {
        FieldFormPurchase,
    },
    methods: {
        cleanShoppingCart() {
            localStorage.setItem('products', JSON.stringify([]));
        },
    },
}).mount('#purchases');
