<x-landing-layout>
    <div class="container mx-auto">
        <div class="bg-white">
            <section class="w-full p-8">
                <form class="relative" action="{{ route('product-search') }}">
                    <input class="relative w-full px-8 py-4 pr-20 rounded-full border-slate-400" type="search" name="search" placeholder="Buscar" value="{{ $search }}">
                    <button class="absolute right-0 w-[58px] h-[58px] rounded-full bg-[#348A7B] text-white cursor-pointer hover:bg-[#296e62]" type="submit">
                        <img class="w-8 h-8 m-[13px]" src="{{ asset('images/search-svgrepo-com.svg') }}" alt="Icono buscar">
                    </button>
                </form>
            </section>

            <section class="mb-8">
                <div class="my-4">
                    {!! $products->links() !!}
                </div>

                <div class="flex flex-wrap">
                    @forelse ($products as $product)
                    <div class="w-full px-4 md:px-0 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
                        <div class="bg-slate-200 mx-4 my-8 p-4 rounded hover:scale-[1.02] duration-150 ease-in-out">
                            <div class="p-8">
                                <img class="w-full" src="{{ asset('images/image-svgrepo-com.svg') }}" alt="Imagen producto">
                            </div>
                            <h4 class="text-base uppercase mb-2">{{ $product->name }}</h4>
                            <span class="block text-sm">{{ $product->brand }}</span>
                            <span class="block text-xl">Bs. {{ $product->price }}</span>
                        </div>
                    </div>
                    @empty
                        <div class="w-full px-4">
                            <div class="bg-slate-200 mx-4 my-8 p-4">
                                No hay productos registrados para: <strong>{{ $search }}</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-landing-layout>