import { createApp } from 'vue';
import ShoppingCart from './ShoppingCart.vue';
import cartMixin from './../mixins/cart-mixin.js';

createApp({
    components: {
        ShoppingCart,
    },
    mixins: [cartMixin],
    data() {
        return {
            products: [],
        };
    },
    created() {
        this.products = JSON.parse(localStorage.getItem('products')) || [];
    },
    methods: {
        addToShoppingCart(event, { id, name, price, url_image, discounts }) {
            let index = this.products.findIndex((product) => {
                return product.id == id;
            });

            if (index != -1) {
                this.products[index].purchase_quantity++;
            } else {
                const product = {
                    id,
                    name,
                    price,
                    url_image,
                    purchase_quantity: 1,
                    discounts,
                };

                this.products.push(product);
            }

            let $button = event.currentTarget;

            $button.classList.add('animate-add-to-cart');
            $button.disabled = true;

            setTimeout(() => {
                $button.classList.remove('animate-add-to-cart');
                $button.disabled = false;
            }, 700);

            localStorage.setItem('products', JSON.stringify(this.products));
        },
    },
}).mount('#shopping-cart');
