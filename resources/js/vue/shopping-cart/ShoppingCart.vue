<script>
import TheModal from './TheModal.vue';

export default {
    name: 'ShoppingCart',
    components: { TheModal },
    props: {
        products: {
            type: Array,
            required: true,
        },
        routeToShoppingCart: {
            type: String,
            required: true,
        },
        totalProducts: {
            type: [Number, String],
            required: true,
        },
        subtotal: {
            type: [Number, String],
            required: true,
        },
    },
    emits: {
        deleteProduct(payload) {
            return !isNaN(payload);
        },
        changeProductQuantity({ productId, purchaseQuantity }) {
            return !isNaN(productId) && !isNaN(purchaseQuantity);
        },
    },
    data() {
        return {
            isOpenModal: false,
        };
    },
    methods: {
        showShoppingCart() {
            this.isOpenModal = true;
        },
    },
};
</script>

<template>
    <Teleport to="body">
        <div class="fixed top-12 lg:top-11 right-8 lg:right-16">
            <button
                class="cursor-pointer relative p-4 bg-white rounded-full border-2 border-slate-100"
                @click="showShoppingCart"
            >
                <svg
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    viewBox="0 0 491.123 491.123"
                    style="
                        enable-background: new 0 0 491.123 491.123;
                        fill: #348a7b;
                    "
                    class="w-10 h-10 lg:w-12 lg:h-12"
                    xml:space="preserve"
                >
                    <g>
                        <g>
                            <path
                                d="M470.223,0.561h-89.7c-9.4,0-16.7,6.3-19.8,14.6l-83.4,263.8h-178.3l-50-147h187.7c11.5,0,20.9-9.4,20.9-20.9
                s-9.4-20.9-20.9-20.9h-215.9c-18.5,0.9-23.2,18-19.8,26.1l63.6,189.7c3.1,8.3,11.5,13.6,19.8,13.6h207.5c9.4,0,17.7-5.2,19.8-13.6
                l83.4-263.8h75.1c11.5,0,20.9-9.4,20.9-20.9S481.623,0.561,470.223,0.561z"
                            />
                            <path
                                d="M103.223,357.161c-36.5,0-66.7,30.2-66.7,66.7s30.2,66.7,66.7,66.7s66.7-30.2,66.7-66.7S139.723,357.161,103.223,357.161z
                 M128.223,424.861c0,14.6-11.5,26.1-25,26.1c-13.6,0-25-11.5-25-26.1s11.5-26.1,25-26.1
                C117.823,398.861,129.323,410.261,128.223,424.861z"
                            />
                            <path
                                d="M265.823,357.161c-36.5,0-66.7,30.2-66.7,66.7s30.2,66.7,66.7,66.7c37.5,0,66.7-30.2,66.7-66.7
                C332.623,387.361,302.323,357.161,265.823,357.161z M290.923,424.861c0,14.6-11.5,26.1-25,26.1c-13.5,0-25-11.5-25-26.1
                s11.5-26.1,25-26.1C280.423,398.861,291.923,410.261,290.923,424.861z"
                            />
                        </g>
                    </g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                    <g></g>
                </svg>
                <span
                    class="absolute top-0 left-0 w-5 h-5 p-0 lg:w-6 lg:h-6 lg:p-[2px] text-center rounded-full bg-[#ff8367] text-sm lg:font-bold text-white"
                >
                    {{ totalProducts }}
                </span>
            </button>
        </div>

        <the-modal
            :is-open="isOpenModal"
            title="Previsualización del carrito"
            @toggle-modal="isOpenModal = !isOpenModal"
        >
            <form ref="form" :action="routeToShoppingCart" method="GET">
                <div v-if="!products.length">
                    No hay productos el en carrito de compras
                </div>

                <template v-else>
                    <transition-group name="list" tag="ul" appear>
                        <li
                            v-for="(product, index) in products"
                            :key="product.id"
                            class="flex justify-between items-center p-2 text-sm"
                        >
                            <span class="uppercase px-2 w-[260px]">
                                {{ product.name }}
                            </span>
                            <input
                                type="hidden"
                                :name="`products[${index}][id]`"
                                :value="product.id"
                            />
                            <input
                                type="number"
                                :value="product.purchase_quantity"
                                min="1"
                                step="1"
                                :name="`products[${index}][purchase_quantity]`"
                                class="w-16 h-12 px-2 rounded-full border-slate-400"
                                @input="
                                    $emit('changeProductQuantity', {
                                        productId: product.id,
                                        purchaseQuantity: $event.target.value,
                                    })
                                "
                            />
                            <span class="px-2 w-[105px]"
                                >Bs.
                                {{ parseFloat(product.price).toFixed(2) }}</span
                            >
                            <span class="px-2 w-[105px]">
                                Bs.
                                {{
                                    parseFloat(
                                        product.purchase_quantity *
                                            product.price
                                    ).toFixed(2)
                                }}
                            </span>
                            <button
                                type="button"
                                class="w-6 h-6 bg-slate-50 hover:bg-[#f89d88] hover:text-white transition-colors rounded-full"
                                @click="$emit('deleteProduct', product.id)"
                            >
                                &times;
                            </button>
                        </li>
                    </transition-group>
                </template>
            </form>

            <template #footer>
                <div>
                    <span class="font-bold">Subtotal: Bs. {{ subtotal }}</span>
                </div>
                <div class="flex justify-around py-4">
                    <button
                        class="px-4 py-2 uppercase bg-[#ff8367] text-white rounded-full"
                        @click="isOpenModal = false"
                    >
                        Seguir Comprando
                    </button>
                    <button
                        class="px-4 py-2 uppercase bg-[#348A7B] text-white rounded-full"
                        @click="$refs.form.submit()"
                    >
                        Ir a Carrito
                    </button>
                </div>
            </template>
        </the-modal>
    </Teleport>
</template>
