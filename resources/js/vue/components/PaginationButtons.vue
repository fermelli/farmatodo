<script>
export default {
    name: 'PaginationButtons',
    props: {
        pagination: {
            type: Object,
            required: true,
            validator(value) {
                return ['current_page', 'last_page'].every(
                    (key) => key in value
                );
            },
        },
        allowedPageSizes: {
            type: Array,
            default() {
                return [5, 10, 15];
            },
        },
        pageSize: {
            type: Number,
            required: true,
        },
    },
    emits: ['getData', 'changeSizePagination'],
    data() {
        return {
            currentSize: this.pageSize,
        };
    },
    methods: {
        emitGetData(page) {
            this.$emit('getData', page);
        },
        emitChangeSizePagination() {
            this.$emit('changeSizePagination', this.currentSize);
        },
    },
};
</script>

<template>
    <div class="mt-8 flex justify-between">
        <div>
            <button
                class="
                    py-2
                    px-4
                    text-white
                    bg-slate-500
                    disabled:bg-slate-300 disabled:cursor-not-allowed
                "
                :disabled="pagination.current_page == 1"
                @click="emitGetData(pagination.current_page - 1)"
            >
                Anterior
            </button>
            <button
                v-for="page in pagination.last_page"
                :key="page"
                class="py-2 px-4 text-white"
                :class="{
                    'bg-slate-500': pagination.current_page != page,
                    'bg-slate-700': pagination.current_page == page,
                }"
                @click="emitGetData(page)"
            >
                {{ page }}
            </button>
            <button
                class="
                    py-2
                    px-4
                    text-white
                    bg-slate-500
                    disabled:bg-slate-300 disabled:cursor-not-allowed
                "
                :disabled="pagination.current_page == pagination.last_page"
                @click="emitGetData(pagination.current_page + 1)"
            >
                Siguiente
            </button>
        </div>
        <div>
            <small class="px-2">N° de registros por página</small>
            <select v-model="currentSize" @change="emitChangeSizePagination">
                <option v-for="n in allowedPageSizes" :key="n" :value="n">
                    {{ n }}
                </option>
            </select>
        </div>
    </div>
</template>