<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar nuevo descuento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div>
                            <div>
                                <a class="inline-block px-4 py-2 my-4 bg-slate-600 text-white" href="{{ route('discounts.index') }}">{{ __('Back') }}</a>
                            </div>
                        </div>
                    </div>
                       
                    @if ($errors->any())
                        <div class="bg-red-100 px-4 py-2">
                            <span class="text-red-900 py-4"><strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}</span>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm text-red-700">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="root-discounts">
                        <form id="discounts-store" action="{{ route('discounts.store') }}" method="POST" v-on:submit="resetLocalStorage">
                            @csrf
                          
                             <div class="w-[400px] mx-auto">
                                <div>
                                    <x-label class="mt-4" for="name" :value="__('Name')" />
    
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="{{ __('Name') }}"  required/>
                                </div>
                                <div>
                                    <x-label class="mt-4" for="percentage" :value="__('Porcentaje')" />
    
                                    <x-input id="percentage" class="block mt-1 w-full" type="number" step="1" min="1" max="15" name="percentage" placeholder="{{ __('Porcentaje') }}"  required/>
                                </div>
                                <div>
                                    <x-label class="mt-4" for="start_date" :value="__('Fecha Inicio')" />
        
                                    <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" required/>
                                </div>
                                <div>
                                    <x-label class="mt-4" for="end_date" :value="__('Fecha Fin')" />
        
                                    <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" required/>
                                </div>
                                <div>
                                    <input v-for="productId in productsIds" :key="productId" type="hidden" name="products[][id]" :value="productId">
                                </div>
                                <div>
                                    <button type="submit" class="px-4 py-2 my-4 bg-blue-600 text-white">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </form>
    
                        <h3 class="my-8">Productos agregados: <span class="py-2 px-4 rounded-full border-[1px] border-slate-400"><strong>@{{ productsIds.length }}</strong> item(s)</span></h3>

                        <div v-if="loading" class="p-28">
                            <div class="spinner"></div>
                        </div>
    
                        <template v-else>

                            <template v-if="productsPagination.data.length">
                                <div class="flex flex-wrap mt-8">
                                    <mini-card-product v-for="product in productsPagination.data" :key="product.id" :product="product" :products-ids="productsIds" v-on:add-product-id="addProductId" />
                                </div>

                                <pagination-buttons
                                    :pagination="{
                                        current_page: productsPagination?.current_page,
                                        last_page: productsPagination?.last_page,
                                    }"
                                    :page-size="size"
                                    :allowed-page-sizes="[20, 30, 40]"
                                    @get-data="getProducts"
                                    @change-size-pagination="changeSizePagination"
                                />
                            </template>

                            <div class="my-8" v-else>
                                No hay productos disponibles para descuento.
                            </div>
                        </template>
                    </div>
                       
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/vue/discounts/main.js') }}"></script>
</x-app-layout>