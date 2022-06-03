<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
    }

    public function providerProducts()
    {
        return [
            'for name' => [
                function () {
                    $category = Category::all()->random();
                    $product = Product::factory()->for($category)->create();
                    return [$product, $product->name];
                },
            ],
            'for type' => [
                function () {
                    $category = Category::all()->random();
                    $product = Product::factory()->for($category)->create();
                    return [$product, $product->type];
                },
            ],
            'for brand' => [
                function () {
                    $category = Category::all()->random();
                    $product = Product::factory()->for($category)->create();
                    return [$product, $product->brand];
                },
            ],
        ];
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerProducts
     */
    public function test_can_see_products_per_category($getData)
    {
        [$product, $search] = $getData();

        $response = $this->get(route('landing'));

        $response->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee($product->brand)
            ->assertSee($product->price);
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerProducts
     */
    public function test_can_do_a_simple_product_search_for($getData)
    {
        [$product, $search] = $getData();

        $response = $this->get(route('product-search', ['search' => $search]));

        $response->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee($product->brand)
            ->assertSee($product->price);
    }

    public function providerProductsForSearchWithCategory()
    {
        return [
            'for name' => [
                function () {
                    $randomCategories = Category::all()->random(3);
                    $products = [
                        Product::factory()->for($randomCategories->get(0))->create(['name' => 'Producto #1']),
                        Product::factory()->for($randomCategories->get(1))->create(['name' => 'Producto #2']),
                        Product::factory()->for($randomCategories->get(2))->create(['name' => 'Producto #3']),
                    ];
                    return [$products, 'Producto', $randomCategories->modelKeys()];
                },
            ],
            'for type' => [
                function () {
                    $randomCategories = Category::all()->random(3);
                    $products = [
                        Product::factory()->for($randomCategories->get(0))->create(['type' => 'Type #1']),
                        Product::factory()->for($randomCategories->get(1))->create(['type' => 'Type #2']),
                        Product::factory()->for($randomCategories->get(2))->create(['type' => 'Type #3']),
                    ];
                    return [$products, 'Type', $randomCategories->modelKeys()];
                },
            ],
            'for brand' => [
                function () {
                    $randomCategories = Category::all()->random(3);
                    $products = [
                        Product::factory()->for($randomCategories->get(0))->create(['brand' => 'Brand #1']),
                        Product::factory()->for($randomCategories->get(1))->create(['brand' => 'Brand #2']),
                        Product::factory()->for($randomCategories->get(2))->create(['brand' => 'Brand #3']),
                    ];
                    return [$products, 'Brand', $randomCategories->modelKeys()];
                },
            ],
        ];
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerProductsForSearchWithCategory
     */
    public function test_can_do_a_product_search_by_categories($getData)
    {
        [$products, $search, $categoriesIds] = $getData();

        $product1 = $products[0];
        $product2 = $products[1];
        $product3 = $products[2];

        $response = $this->get(route('product-search', ['search' => $search, 'categories_ids' => $categoriesIds]));

        $response->assertStatus(200)
            ->assertSee($product1->name)
            ->assertSee($product2->name)
            ->assertSee($product3->name)
            ->assertSee($search)
            ->assertSee($categoriesIds);
    }
}
