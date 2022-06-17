<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Descuentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div>
                            <div>
                                <a class="inline-block px-4 py-2 my-4 bg-green-600 text-white" href="{{ route('discounts.create') }}">
                                    {{ __('Crear nuevo descuento') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    @if ($message = Session::get('success'))
                        <div class="my-4 p-4 bg-green-200">
                            <p>{{ __($message) }}</p>
                        </div>
                    @endif
                    
                    <table class="table mx-auto">
                        <tr>
                            <th>#</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Porcentaje') }}</th>
                            <th>{{ __('Fecha inicio') }}</th>
                            <th>{{ __('Fecha Fin') }}</th>
                            <th>{{ __('Estado') }}</th>
                            <th width="280px">{{ __('Action') }}</th>
                        </tr>
                        @forelse ($discounts as $discount)
                            <tr>
                                <td>{{ (($discounts->currentpage() - 1) * $discounts->perpage()) + $loop->iteration }}</td>
                                <td>{{ $discount->name }}</td>
                                <td>{{ $discount->percentage }}%</td>
                                <td>{{ $discount->start_date }}</td>
                                <td>{{ $discount->end_date }}</td>
                                @if (isset($discount->deleted_at))
                                    <td>
                                        <span class="inline-block bg-red-700 text-white text-xs px-2 rounded-full">Inactivo</span>
                                        <span class="inline-block bg-slate-700 text-white text-xs px-2 rounded-full">
                                            {{ today() < $discount->end_date ? 'Vigente' : 'No vigente' }}
                                        </span>
                                    </td>
                                @else
                                    <td>
                                        <span class="inline-block bg-green-700 text-white text-xs px-2 rounded-full">Activo</span>
                                        <span class="inline-block bg-slate-700 text-white text-xs px-2 rounded-full">
                                            {{ today() < $discount->end_date ? 'Vigente' : 'No vigente' }}
                                        </span>
                                    </td>
                                @endif
                                <td>
                                    
                                    <form action="{{ $discount->deleted_at ? route('discounts.restore', $discount->id) : route('discounts.destroy', $discount->id) }}" method="POST">
                                        <a class="inline-block p-2 my-2 border border-blue-700 text-blue-700" href="{{ route('discounts.show', $discount->id) }}">{{  __('Show') }}</a>
                                        @if (today() < $discount->end_date)
                                            @csrf
                                            @if (!isset($discount->deleted_at))                                                
                                                @method('DELETE')
                                
                                                <button type="submit" class="inline-block p-2 my-2 border border-red-700 text-red-700">{{  __('Desactivar') }}</button>
                                            @else
                                                @method('POST')

                                                <button type="submit" class="inline-block p-2 my-2 border border-green-700 text-green-700">{{  __('Activar') }}</button>
                                            @endif
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">No hay descuentos registrados</td>
                            </tr>
                        @endforelse
                    </table>

                    <div class="my-4">
                        {!! $discounts->links() !!}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>