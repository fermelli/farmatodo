<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div>
                            <div>
                                <a class="inline-block px-4 py-2 my-4 bg-slate-600 text-white" href="{{ route('products.index') }}">{{ __('Back') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div>
                            <strong>{{ __('Name') }}:</strong>
                            {{ $product->name }}
                        </div>
                        <div>
                            <strong>{{ __('Type') }}:</strong>
                            {{ $product->type }}
                        </div>
                        <div>
                            <strong>{{ __('Brand') }}:</strong>
                            {{ $product->brand }}
                        </div>
                        <div>
                            <strong>{{ __('Price') }}:</strong>
                            {{ $product->price }}
                        </div>
                        <div>
                            <strong>{{ __('Quantity') }}:</strong>
                            {{ $product->quantity }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>