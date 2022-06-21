<script>
export default {
    name: 'MiniCardProduct',
    props: {
        product: {
            type: Object,
            required: true,
        },
        productsIds: {
            type: Array,
            required: true,
        },
    },
    emits: ['addProductId'],
};
</script>

<template>
    <div class="w-full px-2 md:px-0 sm:w-1/2 md:w-1/3 lg:w-1/4">
        <label
            class="
                block
                bg-slate-200
                m-2
                p-2
                rounded
                hover:shadow-lg
                transition-shadow
            "
            :for="`product_id_${product.id}`"
        >
            <h4 class="uppercase text-sm">{{ product.name }}</h4>
            <div class="flex justify-between">
                <span class="inline-block text-lg"
                    >Bs. {{ product.price }}</span
                >
                <input
                    :id="`product_id_${product.id}`"
                    class="pointer-events-none"
                    type="checkbox"
                    :value="product.id"
                    :checked="productsIds.indexOf(product.id) != -1"
                    @change="$emit('addProductId', product.id)"
                />
            </div>
        </label>
    </div>
</template>