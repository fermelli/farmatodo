<script>
export default {
    name: 'TheModal',
    props: {
        isOpen: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            required: true,
        },
    },
    emits: ['toggleModal'],
};
</script>

<template>
    <transition name="fade">
        <div
            v-if="isOpen"
            class="fixed top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] z-10 shadow-2xl"
        >
            <div class="modal w-[700px] bg-white rounded">
                <div class="p-4 flex justify-between border-b border-gray-600">
                    <h3 class="text-xl">{{ title }}</h3>
                    <button
                        class="w-6 h-6 rounded-full bg-rose-600 text-white"
                        @click="$emit('toggleModal')"
                    >
                        &times;
                    </button>
                </div>
                <div class="p-4 max-h-96 overflow-y-auto overflow-x-hidden">
                    <slot></slot>
                </div>
                <div class="p-4 border-t border-t-gray-600">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
/* MODAL */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.7s ease-out;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-enter-active .modal,
.fade-leave-active .modal {
    transition: all 0.5s ease-out;
}

.fade-enter-from .modal,
.fade-leave-to .modal {
    opacity: 0;
    transform: scale(1.1);
}
</style>
