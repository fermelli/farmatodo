<script>
import ShoppingCartItem from './ShoppingCartItem.vue';
import ShoppingCartIcon from './ShoppingCartIcon.vue';
import TheModal from './TheModal.vue';

export default {
    name: 'ShoppingCart',
    components: { TheModal, ShoppingCartItem, ShoppingCartIcon },
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
                class="
                    cursor-pointer
                    relative
                    p-4
                    bg-white
                    rounded-full
                    border-2 border-slate-100
                "
                @click="showShoppingCart"
            >
                <shopping-cart-icon />
                <span
                    class="
                        absolute
                        top-0
                        left-0
                        w-5
                        h-5
                        p-0
                        lg:w-6 lg:h-6 lg:p-[2px]
                        text-center
                        rounded-full
                        bg-[#ff8367]
                        text-sm
                        lg:font-bold
                        text-white
                    "
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
                        <shopping-cart-item
                            v-for="(product, index) in products"
                            :key="product.id"
                            :index="index"
                            :product="product"
                            @change-product-quantity="
                                (payload) =>
                                    $emit('changeProductQuantity', payload)
                            "
                            @delete-product="
                                (payload) => $emit('deleteProduct', payload)
                            "
                        />
                    </transition-group>
                </template>
            </form>

            <template #footer>
                <div>
                    <span class="font-bold">Subtotal: Bs. {{ subtotal }}</span>
                </div>
                <div class="flex justify-around py-4">
                    <button
                        class="
                            px-4
                            py-2
                            uppercase
                            bg-[#ff8367]
                            text-white
                            rounded-full
                        "
                        @click="isOpenModal = false"
                    >
                        Seguir Comprando
                    </button>
                    <button
                        class="
                            px-4
                            py-2
                            uppercase
                            bg-[#348A7B]
                            text-white
                            rounded-full
                        "
                        @click="$refs.form.submit()"
                    >
                        Ir a Carrito
                    </button>
                </div>
            </template>
        </the-modal>
    </Teleport>
</template>
