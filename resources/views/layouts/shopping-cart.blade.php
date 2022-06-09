<x-landing-layout>
    {{ $slot }}

    <shopping-cart :products="products"  @delete-product="deleteProduct" @change-product-quantity="changeProductQuantity" route-to-shopping-cart="{{ route('purchases') }}" :total-products="totalProducts" :subtotal="subtotal" />

</x-landing-layout>

<script src="{{ asset('js/vue/shopping-cart/main.js') }}"></script>