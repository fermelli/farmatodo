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
                                <a class="inline-block px-4 py-2 my-4 bg-slate-600 text-white" href="{{ route('products.index') }}">{{ __('Back') }}</a>
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
                  
                    <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-1/2">
                                <div class="w-[400px] mx-auto">
                                    <div>
                                        <x-label class="mt-4" for="name" :value="__('Name')" />
        
                                        <x-input id="name" class="block mt-1 w-full" type="text" value="{{ $product->name }}" name="name" placeholder="{{ __('Name') }}" required />
                                    </div>
                                    <div>
                                        <x-label class="mt-4" for="type" :value="__('Type')" />
        
                                        <x-input id="type" class="block mt-1 w-full" type="text" value="{{ $product->type }}" name="type" placeholder="{{ __('Type') }}" required />
                                    </div>
                                    <div>
                                        <x-label class="mt-4" for="brand" :value="__('Brand')" />
        
                                        <x-input id="brand" class="block mt-1 w-full" type="text" value="{{ $product->brand }}" name="brand" placeholder="{{ __('Brand') }}" required />
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
                                        <x-label class="mt-4" for="category_id" :value="__('Category')" />
        
                                        <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="category_id" id="category_id" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="w-full lg:w-1/2">
                                <div class="w-[400px] mx-auto">
                                    <div class="p-12">
                                        <img src="{{ $product->url_image ? asset($product->url_image) : asset('images/image-svgrepo-com.svg') }}" alt="{{ $product->name }}">
                                    </div>
                                    <div>
                                        <x-label class="mt-4" for="image" :value="__('Cambiar imagen')" />
        
                                        <x-input id="image" class="block mt-1 w-full border-[1px] px-3 py-[5px] focus:outline-none" type="file" step="0.001" name="image" accept=".png, .jpg, .jpeg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="px-4 py-2 my-4 bg-blue-600 text-white">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>