<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Models\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::withTrashed()->latest()->paginate(5);

        return view('discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDiscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscountRequest $request)
    {
        $request->safe();

        $discount = new Discount();
        $discount->fill($request->except('products'));
        $discount->save();

        $products = collect($request->input('products'))->pluck('id');
        $discount->products()->attach($products);

        return redirect()->route('discounts.index')
            ->with('success', 'Descuento creado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $discountId
     * @return \Illuminate\Http\Response
     */
    public function show(int $discountId)
    {
        $discount = Discount::withTrashed()
            ->where('id', $discountId)
            ->first();

        return view('discounts.show', ['discount' => $discount]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index')
            ->with('success', 'Descuento desactivado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $discountId
     * @return \Illuminate\Http\Response
     */
    public function restore(int $discountId)
    {
        $discount = Discount::withTrashed()
            ->where('id', $discountId)
            ->first();

        $discount->restore();

        return redirect()->route('discounts.index')
            ->with('success', 'Descuento activado con éxito.');
    }
}
