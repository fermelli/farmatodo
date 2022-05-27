<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div>
                            <div>
                                <a class="inline-block px-4 py-2 my-4 bg-slate-600 text-white" href="{{ route('products.index') }}">Back</a>
                            </div>
                        </div>
                    </div>
                   
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                  
                    <form action="{{ route('products.update',$product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="w-[400px] mx-auto">
                            <div>
                                <x-label class="mt-4" for="name" :value="__('Name')" />

                                <x-input id="name" class="block mt-1 w-full" type="text" value="{{ $product->name }}" name="name" placeholder="Name" required />
                            </div>
                            <div>
                                <x-label class="mt-4" for="type" :value="__('Type')" />

                                <x-input id="type" class="block mt-1 w-full" type="text" value="{{ $product->type }}" name="type" placeholder="Type" required />
                            </div>
                            <div>
                                <x-label class="mt-4" for="brand" :value="__('Brand')" />

                                <x-input id="brand" class="block mt-1 w-full" type="text" value="{{ $product->brand }}" name="brand" placeholder="Brand" required />
                            </div>
                            <div>
                                <x-label class="mt-4" for="price" :value="__('Price')" />

                                <x-input id="price" class="block mt-1 w-full" type="number" value="{{ $product->price }}" step="0.001" name="price" placeholder="0.0" required />
                            </div>
                            <div>
                                <x-label class="mt-4" for="quantity" :value="__('Quantity')" />

                                <x-input id="quantity" class="block mt-1 w-full" type="number" value="{{ $product->quantity }}" step="1" name="quantity" placeholder="0" required />
                            </div>
                            <div>
                                    <button type="submit" class="px-4 py-2 my-4 bg-blue-600 text-white">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>