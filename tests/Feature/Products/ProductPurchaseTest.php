<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CategorySeeder::class);
    }

    public function test_purchase_screen_can_be_rendered()
    {
        $response = $this->get(route('purchases', ['products' => []]));

        $response->assertStatus(200);
    }

    public function test_retrieve_products_to_buy()
    {
        $products = Product::factory()->count(5)->for(Category::all()->random())->create();

        $data = $products->map(function ($product) {
            return ['id' => $product->id, 'purchase_quantity' => rand(1, 5)];
        });

        $response = $this->get(route('purchases', ['products' => $data->toArray()]));

        $responseData = $response->getOriginalContent()->getData();

        $this->assertEquals($products->count(), $responseData['products']->count());

        $response->assertSessionHasNoErrors()
            ->assertViewHas('products');
    }

    public function providerProductIdsAndPurchaseQuantities()
    {
        return [
            'without id' => [
                function () {
                    return [['purchase_quantity' => 5], 'products.*.id'];
                },
            ],
            'without purchase quantity' => [
                function () {
                    $product = Product::factory()->for(Category::all()->random())->create();
                    return [['id' => $product->id], 'products.*.purchase_quantity'];
                },
            ],
            'with product id no exists' => [
                function () {
                    return [['id' => 1, 'purchase_quantity' => 5], 'products.*.id'];
                },
            ],
            'with purchase quantity out range' => [
                function () {
                    $product = Product::factory()->for(Category::all()->random())->create();
                    return [['id' => $product->id, 'purchase_quantity' => 0], 'products.*.purchase_quantity'];
                },
            ],
        ];
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerProductIdsAndPurchaseQuantities
     */
    public function test_retrieve_products_to_buy_without_sending_parameters_correctly($getData)
    {
        [$data, $keyError] = $getData();

        $response = $this->get(route('purchases', ['products' => $data]));

        $response->assertSessionHasErrors()
            ->assertSessionHasErrors($keyError);
    }
}
