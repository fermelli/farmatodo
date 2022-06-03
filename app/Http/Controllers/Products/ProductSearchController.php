<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        $productsByCategory = $categories->mapWithKeys(function ($category) {
            return [$category['name'] => Product::where('category_id', $category->id)->latest()->take(5)->get()];
        });

        return view('welcome', ['productsByCategory' => $productsByCategory]);
    }

    public function search(Request $request)
    {
        $search = $request->query('search', '');

        $products = Product::where('name', 'LIKE', "%$search%")
            ->orWhere('type', 'LIKE', "%$search%")
            ->orWhere('brand', 'LIKE', "%$search%")
            ->with('category')->paginate(20);

        return view('products.search', ['products' => $products, 'search' => $search]);
    }
}
