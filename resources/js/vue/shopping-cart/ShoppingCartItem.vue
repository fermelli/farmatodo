<script>
import cartItemMixin from './../mixins/cart-item-mixin';

export default {
    name: 'ShoppingCartItem',
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
    },
    emits: ['deleteProduct', 'changeProductQuantity'],
};
</script>

<template>
    <li class="flex justify-between items-center p-2 text-sm">
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
        <div v-if="product.discounts.length" class="w-[105px]">
            <span class="block px-2 line-through text-xs text-slate-500">
                Bs.{{ parseFloat(product.price).toFixed(2) }}
            </span>
            <span class="block px-2">
                Bs.{{ parseFloat(discount).toFixed(2) }}
            </span>
        </div>
        <span v-else class="px-2 w-[105px]">
            Bs.{{ parseFloat(product.price).toFixed(2) }}
        </span>
        <span class="px-2 w-[105px]"> Bs. {{ totalPrice }} </span>
        <button
            type="button"
            class="
                w-6
                h-6
                bg-slate-50
                hover:bg-[#f89d88] hover:text-white
                transition-colors
                rounded-full
            "
            @click="$emit('deleteProduct', product.id)"
        >
            &times;
        </button>
    </li>
</template>