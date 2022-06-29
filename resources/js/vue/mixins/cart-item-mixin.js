export default {
    computed: {
        discount() {
            return (
                this.product.price *
                ((100 - this.product.discounts[0].percentage) / 100)
            );
        },
        totalPrice() {
            let price = this.product.discounts.length
                ? this.discount
                : this.product.price;
            return parseFloat(price * this.product.purchase_quantity).toFixed(
                2
            );
        },
    },
};
