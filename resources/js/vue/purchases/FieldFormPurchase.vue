<script>
import cartMixin from './../mixins/cart-mixin';
import FieldFormPurchaseItem from './FieldFormPurchaseItem.vue';

export default {
    name: 'FieldFormPurchase',
    components: {
        FieldFormPurchaseItem,
    },
    mixins: [cartMixin],
    props: {
        validateProducts: {
            type: Array,
            required: true,
        },
        urlDefaultImage: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            products: this.validateProducts,
        };
    },
    created() {
        localStorage.setItem('products', JSON.stringify(this.products));
    },
    methods: {
        submitPurchase() {
            localStorage.setItem('products', JSON.stringify([]));
        },
    },
};
</script>

<template>
    <transition-group name="list" tag="ul" appear>
        <field-form-purchase-item
            v-for="(product, index) in products"
            :key="product.id"
            :product="product"
            :index="index"
            :url-default-image="urlDefaultImage"
            @change-product-quantity="
                (payload) => changeProductQuantity(payload)
            "
            @delete-product="(payload) => deleteProduct(payload)"
        />
        <!-- <li
            v-for="(product, index) in products"
            :key="product.id"
            class="
                flex
                justify-between
                items-center
                py-4
                border-b-2 border-b-slate-200
            "
        >
            <input
                type="hidden"
                :name="`products[${index}][id]`"
                :value="product.id"
            />
            <input
                type="hidden"
                :name="`products[${index}][purchase_quantity]`"
                :value="product.purchase_quantity"
            />
            <div class="w-16 h-16 p-2">
                <img :src="urlDefaultImage" :alt="product.name" />
            </div>
            <div class="w-[340px]">
                <span class="uppercase block">{{ product.name }}</span>
                <template v-if="product.discounts.length">
                    <span
                        class="block text-xs mt-2 text-slate-500 line-through"
                    >
                        Bs. {{ parseFloat(product.price).toFixed(2) }} c/u
                    </span>
                    <span class="block text-sm mt-2">
                        Bs.
                        {{
                            parseFloat(
                                product.price *
                                    ((100 - product.discounts[0].percentage) /
                                        100)
                            ).toFixed(2)
                        }}
                        c/u
                    </span>
                </template>
                <span v-else class="block text-sm mt-2">
                    Bs. {{ parseFloat(product.price).toFixed(2) }} c/u
                </span>
            </div>
            <div class="px-4">
                <div class="flex justify-center">
                    <button
                        type="button"
                        class="
                            w-12
                            h-12
                            p-2
                            rounded-full
                            mr-4
                            text-2xl
                            bg-slate-200
                        "
                        @click="
                            changeProductQuantity({
                                productId: product.id,
                                purchaseQuantity: product.purchase_quantity - 1,
                            })
                        "
                    >
                        -
                    </button>
                    <span
                        class="
                            inline-block
                            w-12
                            h-12
                            p-2
                            text-center text-lg
                            bg-slate-100
                            text-slate-600
                        "
                        >{{ product.purchase_quantity }}</span
                    >
                    <button
                        type="button"
                        class="
                            w-12
                            h-12
                            p-2
                            rounded-full
                            ml-4
                            text-2xl
                            bg-slate-200
                        "
                        @click="
                            changeProductQuantity({
                                productId: product.id,
                                purchaseQuantity: product.purchase_quantity + 1,
                            })
                        "
                    >
                        +
                    </button>
                </div>
                <div class="text-sm mt-2 font-medium">
                    Bs.
                    {{
                        parseFloat(
                            product.price * product.purchase_quantity
                        ).toFixed(2)
                    }}
                </div>
            </div>
            <div class="flex items-start">
                <button
                    type="button"
                    class="
                        w-8
                        h-8
                        rounded-full
                        text-lg
                        border-2 border-[#ff8367]
                        text-[#ff8367]
                    "
                    @click="deleteProduct(product.id)"
                >
                    &times;
                </button>
            </div>
        </li> -->
    </transition-group>

    <div v-if="products.length">
        <h3 class="my-4 py-2 text-lg">Subtotal</h3>
        <span class="text-lg font-bold">Bs. {{ subtotal }}</span>
    </div>

    <div class="py-4">
        <input
            class="
                w-full
                py-2
                px-4
                bg-[#4bc7b2]
                hover:bg-[#348A7B]
                text-white
                rounded-full
                uppercase
            "
            type="submit"
            value="Comprar"
            @click="submitPurchase"
        />
    </div>
</template>
