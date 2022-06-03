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
    public function test_can_do_a_product_search_for($getData)
    {
        [$product, $search] = $getData();

        $response = $this->get(route('product-search', ['search' => $search]));

        $response->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee($product->brand)
            ->assertSee($product->price);
    }
}
