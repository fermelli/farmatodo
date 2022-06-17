<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mostrar descuento') }}
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
                    
                    <div class="w-full lg:w-1/2">
                        <div>
                            <strong>{{ __('Name') }}:</strong>
                            {{ $discount->name }}
                        </div>
                        <div>
                            <strong>{{ __('Porcentaje') }}:</strong>
                            {{ $discount->percentage }}%
                        </div>
                        <div>
                            <strong>{{ __('Fecha inicio') }}:</strong>
                            {{ $discount->start_date }}
                        </div>
                        <div>
                            <strong>{{ __('Fecha Fin') }}:</strong>
                            {{ $discount->end_date }}
                        </div>
                        @if (isset($discount->deleted_at))
                            <div>
                                <span class="inline-block bg-red-700 text-white text-base my-2 px-2 rounded-full">Inactivo</span>
                            </div>
                            <div>
                                <span class="inline-block bg-slate-700 text-white text-base my-2 px-2 rounded-full">
                                    {{ today() < $discount->end_date ? 'Vigente' : 'No vigente' }}
                                </span>
                            </div>
                        @else
                        <div>
                            <span class="inline-block bg-green-700 text-white text-base my-2 px-2 rounded-full">Activo</span>
                            <div>
                                <span class="inline-block bg-slate-700 text-white text-base my-2 px-2 rounded-full">
                                    {{ today() < $discount->end_date ? 'Vigente' : 'No vigente' }}
                                </span>
                            </div>
                        </div>

                        @endif
                    </div>

                    <h3 class="my-8">Productos con descuento: <span class="py-2 px-4 rounded-full border-[1px] border-slate-400"><strong>{{ count($discount->products) }}</strong> item(s)</span></h3>

                    <div class="flex flex-wrap mt-8">
                        @forelse ($discount->products as $product)
                            <div class="w-full px-2 md:px-0 sm:w-1/2 md:w-1/3 lg:w-1/4">
                                <label class="block bg-slate-200 m-2 p-2 rounded hover:shadow-lg transition-shadow">
                                    <h4 class="uppercase text-sm">{{ $product->name }}</h4>
                                    <div class="flex justify-between">
                                        <span class="inline-block text-lg">Bs. {{ $product->price }}</span>
                                    </div>
                                </label>
                            </div>
                        @empty
                            <div class="my-8" v-else>
                                No hay productos registrados.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>