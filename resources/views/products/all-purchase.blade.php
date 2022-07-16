<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todas las compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($purchases) > 0)
                        <div class="my-4 py-4">
                            <table class="table mx-auto">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Cantidad de productos</th>
                                    <th>Total</th>
                                    <th>Acción</th>
                                </tr>
                                @foreach ($purchases as $purchase)
                                <tr>
                                    <td>{{ (($purchases->currentpage() - 1) * $purchases->perpage()) + $loop->iteration }}</td>
                                    <td>{{ $purchase->created_at }}</td>
                                    @php
                                        $total = 0;
                                        $totalQuantity = 0;
                                    @endphp
                                    @foreach ($purchase->products as $product)
                                        @php
                                            $totalQuantity += $product->detail->quantity;
                                            $total += $product->detail->quantity * $product->detail->price;
                                        @endphp
                                    @endforeach
                                    <td class="text-right">{{ $totalQuantity }}</td>
                                    <td class="text-right">{{ $total }}</td>
                                    <td><a class="inline-block p-2 my-2 border border-green-700 text-green-700" href="{{ route('purchases.show', $purchase->id) }}">Ver detalle</a></td>
                                </tr>
                                @endforeach
                            </table>

                            
                            <div class="my-4">
                                {!! $purchases->links() !!}
                            </div>
                        </div>
                    @else
                        No hay compras realizadas
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
