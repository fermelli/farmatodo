@props(['product'])

<div class="bg-slate-50 mx-4 my-8 p-4 rounded hover:shadow-lg transition-shadow">
    <div class="p-4">
        <img class="w-full" src="{{ $product->url_image }}" alt="{{ $product->name }}">
    </div>
    <h4 class="text-base uppercase mb-2">{{ $product->name }}</h4>
    <span class="block text-sm">{{ $product->brand }}</span>
    
    @php
        $discount = $product->discounts->get(0)
    @endphp
    @if ($discount)
        <span class="block text-sm text-center text-slate-500"><small>Antes</small> <span class="line-through">Bs. {{ $product->price }}</span></span>
        <span class="block text-lg text-center"><small>Ahora</small> Bs. {{ $product->price * (1 - $discount->percentage/100) }}</span>
    @else
        <span class="block text-lg text-center">Bs. {{ $product->price }}</span>
    @endif
    <button class="block px-4 py-2 bg-[#4bc7b2] hover:bg-[#348A7B] text-white uppercase rounded-full mt-4 mx-auto text-sm" v-on:click="addToShoppingCart($event, {{ json_encode($product) }})">
        <svg
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            viewBox="0 0 491.123 491.123"
            style="enable-background: new 0 0 491.123 491.123; fill: white"
            xml:space="preserve"
            class="inline-block w-5 h-5 mr-2"
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
        Añadir
    </button>
</div>