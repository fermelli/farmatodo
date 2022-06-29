<script>
import cartItemMixin from './../mixins/cart-item-mixin';

export default {
    name: 'FieldFormPurchaseItem',
    mixins: [cartItemMixin],
    props: {
        product: {
            type: Object,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
        urlDefaultImage: {
            type: String,
            required: true,
        },
    },
    emits: ['deleteProduct', 'changeProductQuantity'],
    computed: {
        sourceImage() {
            return this.product.url_image || this.urlDefaultImage;
        },
    },
};
</script>

<template>
    <li
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
            <img :src="sourceImage" :alt="product.name" />
        </div>
        <div class="w-[340px]">
            <span class="uppercase block">{{ product.name }}</span>
            <template v-if="product.discounts.length">
                <span class="block text-xs mt-2 text-slate-500 line-through">
                    Bs. {{ parseFloat(product.price).toFixed(2) }} c/u
                </span>
                <span class="block text-sm mt-2">
                    Bs.
                    {{ parseFloat(discount).toFixed(2) }}
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
                        $emit('changeProductQuantity', {
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
                        $emit('changeProductQuantity', {
                            productId: product.id,
                            purchaseQuantity: product.purchase_quantity + 1,
                        })
                    "
                >
                    +
                </button>
            </div>
            <div class="text-sm mt-2 font-medium">Bs. {{ totalPrice }}</div>
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
                @click="$emit('deleteProduct', product.id)"
            >
                &times;
            </button>
        </div>
    </li>
</template>