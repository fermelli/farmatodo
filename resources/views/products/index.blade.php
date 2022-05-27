<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div>
                            <div>
                                <a class="inline-block px-4 py-2 my-4 bg-green-600 text-white" href="{{ route('products.create') }}">
                                    {{ __('Create new product') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    @if ($message = Session::get('success'))
                        <div class="my-4 p-4 bg-green-200">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    
                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>type</th>
                            <th>brand</th>
                            <th>price</th>
                            <th>quantity</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->type }}</td>
                            <td>{{ $product->brand }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity}}</td>
                            <td>
                                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    
                                    <a class="inline-block px-4 py-2 border border-green-700 text-green-700" href="{{ route('products.show',$product->id) }}">Show</a>
                    
                                    <a class="inline-block px-4 py-2 border border-blue-700 text-blue-700" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    
                                    @csrf
                                    @method('DELETE')
                      
                                    <button type="submit" class="inline-block px-4 py-2 border border-red-700 text-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div class="my-4">
                        {!! $products->links() !!}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>