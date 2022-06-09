export default {
    methods: {
        deleteProduct(productId) {
            let index = this.products.findIndex((product) => {
                return product.id == productId;
            });

            if (index != -1) {
                this.products.splice(index, 1);
                localStorage.setItem('products', JSON.stringify(this.products));
            }
        },
        changeProductQuantity({ productId, purchaseQuantity }) {
            let index = this.products.findIndex((product) => {
                return product.id == productId;
            });

            if (index != -1) {
                if (purchaseQuantity <= 0) {
                    this.deleteProduct(this.products[index].id);
                } else {
                    this.products[index].purchase_quantity = purchaseQuantity;
                }

                localStorage.setItem('products', JSON.stringify(this.products));
            }
        },
    },
    computed: {
        totalProducts() {
            return this.products.reduce(
                (previousValue, currentValue) =>
                    previousValue + parseInt(currentValue.purchase_quantity),
                0
            );
        },
        subtotal() {
            let subtotal = this.products.reduce(
                (previousValue, currentValue) =>
                    previousValue +
                    currentValue.purchase_quantity * currentValue.price,
                0
            );
            return parseFloat(subtotal).toFixed(2);
        },
    },
};
