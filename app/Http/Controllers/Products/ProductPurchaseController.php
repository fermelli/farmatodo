<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPurchaseRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductPurchaseRequest $request)
    {
        if (!$request->has('products')) {
            return view('products.purchases', ['products' => []]);
        }

        $validated = $request->validated();

        $products = collect($validated['products']);

        $productsIds = $products->pluck('id');

        $purchaseQuantities = $products->pluck('purchase_quantity');

        $products = Product::with('category')->whereIn('id', $productsIds)->get()
            ->map(function ($product, $index) use ($purchaseQuantities) {
                return Arr::add($product, 'purchase_quantity', intval($purchaseQuantities[$index]));
            });

        return view('products.purchases', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductPurchaseRequest $request)
    {
        if ($request->has('products')) {
            $validated = $request->validated();

            $products = collect($validated['products']);

            $productsIds = $products->pluck('id');

            $purchaseQuantities = $products->pluck('purchase_quantity');

            $productsToPurchase = Product::whereIn('id', $productsIds)->get();

            $purchase = null;

            try {
                DB::beginTransaction();

                $purchase = new Purchase();
                $purchase->user()->associate(Auth::user());
                $purchase->save();

                $productsToPurchase->each(function ($productToPurchase, $index) use ($purchase, $purchaseQuantities) {
                    $purchase->products()->attach($productToPurchase->id, ['quantity' => $purchaseQuantities[$index]]);
                });

                DB::commit();

                return redirect()->route('purchases.show', $purchase->id)
                    ->with('success', 'Compra registrada exitosamente.');
            } catch (\Throwable $th) {
                DB::rollBack();

                return redirect()->back();
            }
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->products;
        return view('products.show-purchase', ['purchase' => $purchase]);
    }

    public function all()
    {
        $purchases = Purchase::where('user_id', auth()->user()->id)
            ->latest()->with('products')->paginate(5);
        return view('products.all-purchase', ['purchases' => $purchases]);
    }
}
