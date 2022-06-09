<x-landing-layout>
    <div class="container mx-auto" id="purchases">
        <div class="w-[800px] mx-auto py-12">
            <h2 class="text-[#348A7B] font-[Poppins] text-4xl text-center my-16 w-full px-4">Mi carrito de compras</h2>
            @if ($errors->any())
                <div class="bg-red-100 px-4 py-2">
                    <div class="flex justify-between items-center">
                        <span class="text-red-900 py-4"><strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}</span>
                        <a class="py-2 px-4 bg-[#348A7B] rounded-full text-white" href="{{ route('product-search') }}" v-on:click="cleanShoppingCart">Volver a intentar</a>
                    </div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-sm text-red-700">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                @if (count($products) > 0)
                    <form action="{{ route('purchases.store') }}" method="POST">
                        @csrf
                        <field-form-purchase :validate-products="{{ json_encode($products) }}" url-default-image="{{ asset('images/image-svgrepo-com.svg') }}"/>
                    </form>
                @else
                    <div class="my-16 py-4">No hay productos en el carrito de compras, ir a <a class="underline text-[#348A7B]" href="{{ route('product-search') }}">Buscar producto</a></div>                
                @endif
            @endif
        </div>
    </div>

    <script src="{{ asset('js/vue/purchases/main.js') }}"></script>
</x-landing-layout>