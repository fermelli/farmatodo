<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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

                    <form class= "w-[500px] mx-auto" action="{{route('report')}}" method="GET" >
                        <div>
                            <x-label class="mt-4" for="start_date" :value="__('Fecha Inicio')" />

                            <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" value="{{ request('start_date') }}" required/>
                        </div>
                        <div>
                            <x-label class="mt-4" for="end_date" :value="__('Fecha Fin')" />

                            <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" value="{{ request('end_date') }}" required/>
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 my-4 bg-blue-600 text-white">{{ __('Search') }}</button>
                        </div>
                    </form >
                    @if (count($purchases) > 0)
                        <div class="my-4 py-4">
                            <table class="table mx-auto">
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Cantidad de productos</th>
                                    <th>Total</th>
                                </tr>
                                @foreach ($purchases as $purchase)
                                <tr>
                                    <td>{{ (($purchases->currentpage() - 1) * $purchases->perpage()) + $loop->iteration }}</td>
                                    <td>{{ $purchase->user->name }}</td>
                                    <td>{{ $purchase->created_at }}</td>
                                    @php
                                        $total = 0;
                                        $totalQuantity = 0;
                                    @endphp
                                    @foreach ($purchase->products as $product)
                                        @php
                                            $totalQuantity += $product->detail->quantity;
                                            $total += $product->detail->quantity * $product->price;
                                        @endphp
                                    @endforeach
                                    <td class="text-right">{{ $totalQuantity }}</td>
                                    <td class="text-right">{{ $total }}</td>
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