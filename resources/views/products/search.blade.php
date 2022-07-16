<x-shopping-cart-layout>
    <div class="container mx-auto">
        <div class="bg-white">
            <section class="w-full p-8">
                <form class="flex flex-wrap" action="{{ route('product-search') }}">
                    <div class="w-full mb-8 lg:w-1/5 lg:mb-0">
                        <h3 class="text-xl font-bold text-[#535151] py-2">Categorias</h3>
                        @foreach ($categories as $category)                            
                            <label class="block" for="{{ $category->id }}">
                                <input type="checkbox" name="categories_ids[]" id="{{ $category->id }}" value="{{ $category->id }}" {{ isset($selectedCategories) && $selectedCategories->find($category->id) != null ? 'checked' : '' }}>
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                    <div class="relative w-full lg:w-4/5 my-auto">
                        <input class="relative w-full px-8 py-4 pr-20 rounded-full border-slate-400" type="search" name="search" placeholder="Buscar" value="{{ $search }}">
                        <button class="absolute right-0 w-[58px] h-[58px] rounded-full bg-[#348A7B] text-white cursor-pointer hover:bg-[#296e62]" type="submit">
                            <img class="w-8 h-8 m-[13px]" src="{{ asset('images/search-svgrepo-com.svg') }}" alt="Icono buscar">
                        </button>
                    </div>
                </form>
            </section>

            <section class="mb-8">
                @isset($products)
                    <h3 class="font-[Poppins] mx-4 text-xl text-[#6c7480]">Todos</h3>

                    <div class="my-4">
                        {!! $products->links() !!}
                    </div>

                    <div class="flex flex-wrap">
                        @forelse ($products as $product)
                        <div class="w-full px-4 md:px-0 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
                            <x-product-card :product="Arr::add($product, 'url_image', asset('images/image-svgrepo-com.svg'))" />
                        </div>
                        @empty
                            <div class="w-full px-4">
                                <div class="bg-slate-200 mx-4 my-8 p-4">
                                    No hay productos registrados para: <strong>{{ $search }}</strong>
                                </div>
                            </div>
                        @endforelse
                    </div>
                @endisset

                @isset($productsByCategory)
                    @forelse ($productsByCategory as $categoryName => $products)
                        @if (count($products) > 0)
                            <h3 class="font-[Poppins] mx-4 text-xl text-[#6c7480]">{{ $categoryName }}</h3>

                            <div class="flex flex-wrap">
                                @foreach ($products as $product)
                                    <div class="w-full px-4 md:px-0 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
                                        <x-product-card :product="Arr::add($product, 'url_image', asset('images/image-svgrepo-com.svg'))" />
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @empty
                        <div class="w-full px-4">
                            <div class="bg-slate-200 my-8 p-4">
                                No hay productos registrados
                            </div>
                        </div>
                    @endforelse
                @endisset
            </section>
        </div>
    </div>
</x-shopping-cart-layout>