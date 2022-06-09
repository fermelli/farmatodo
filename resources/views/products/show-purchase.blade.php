<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos comprados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div>
                            <div>
                                <a class="inline-block px-4 py-2 my-4 bg-slate-600 text-white" href="{{ route('purchases.all') }}">{{ __('Ver todas mis compras') }}</a>
                            </div>
                        </div>
                    </div>

                    @if (isset($purchase))
                        @if ($message = Session::get('success'))
                            <div class="my-4 p-4 bg-green-200">
                                <p>{{ __($message) }}</p>
                            </div>
                        @endif
                        <div>
                            <span class="block text-right">Fecha: {{ $purchase->created_at }}</span>
                        </div>  
                        <div class="my-4 py-4">
                            @php
                                $total = 0;
                            @endphp
                            <table class="table mx-auto">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Brand') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Cantidad comprada') }}</th>
                                    <th>{{ __('Subtotal') }}</th>
                                </tr>
                                @foreach ($purchase->products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td class="text-right">{{ $product->price }}</td>
                                    <td class="text-right">{{ $product->detail->quantity }}</td>
                                    <td class="text-right">{{ $product->price * $product->detail->quantity }}</td>
                                </tr>
                                @php
                                    $total += $product->price * $product->detail->quantity
                                @endphp
                                @endforeach
                                <tr>
                                    <th colspan="5">Total</th>
                                    <td><span class="text-xl font-bold">{{ $total }}</span></td>
                                </tr>
                            </table>
                        </div>
                    @else
                        No se realizó la compra
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
