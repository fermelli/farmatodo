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
            return [$category['name'] => Product::with(['discounts' => function ($query) {
                $query->activeAndInForce();
            }])
                ->where('category_id', $category->id)->latest()->take(5)->get()];
        });

        return view('welcome', ['productsByCategory' => $productsByCategory]);
    }

    public function search(Request $request)
    {
        $search = $request->query('search', '');

        $categoriesIds = $request->query('categories_ids', []);

        $selectedCategories = Category::whereIn('id', $categoriesIds)->get();

        $additionalData = ['search' => $search, 'categories' => Category::all()];

        if ($selectedCategories->count() > 0) {
            $productsByCategory = $selectedCategories->mapWithKeys(function ($category) use ($search) {
                return [$category['name'] => Product::with(['discounts' => function ($query) {
                    $query->activeAndInForce();
                }])->where('category_id', $category->id)
                    ->where(function ($query) use ($search) {
                        $query->searchBy($search);
                    })->get()];
            });

            return view('products.search', [
                'productsByCategory' => $productsByCategory,
                'selectedCategories' => $selectedCategories,
                ...$additionalData,
            ]);
        }

        $products = Product::with(['discounts' => function ($query) {
            $query->activeAndInForce();
        }])->searchBy($search)
            ->with('category')->paginate(20);

        return view('products.search', ['products' => $products, ...$additionalData]);
    }
}
