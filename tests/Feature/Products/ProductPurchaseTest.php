<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, UserSeeder::class, CategorySeeder::class]);
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

        $response->assertSessionHasErrors($keyError);
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerProductIdsAndPurchaseQuantities
     */
    public function test_store_purchase_without_sending_parameters_correctly($getData)
    {
        [$data, $keyError] = $getData();

        $user = User::where('email', 'user.user@email.com')->first();

        $response = $this->actingAs($user)->from(route('purchases'))
            ->post(route('purchases.store'), ['products' => $data]);

        $response->assertSessionHasErrors($keyError);
    }

    public function providerUsersDataAndStatus()
    {
        return [
            'super-admin' => [
                function () {
                    $product = Product::factory()->for(Category::all()->random())->create();
                    $data = ['id' => $product->id, 'purchase_quantity' => 5];
                    return [User::where('email', 'testeo.test.55@gmail.com')->first(), $data, 403];
                },
            ],
            'admin' => [
                function () {
                    $product = Product::factory()->for(Category::all()->random())->create();
                    $data = ['id' => $product->id, 'purchase_quantity' => 5];
                    return [User::where('email', 'admin@email.com')->first(), $data, 403];
                },
            ],
            'user' => [
                function () {
                    $product = Product::factory()->for(Category::all()->random())->create();
                    $data = ['id' => $product->id, 'purchase_quantity' => 5];
                    return [User::where('email', 'user.user@email.com')->first(), $data, 200];
                },
            ],
            'guest' => [
                function () {
                    $product = Product::factory()->for(Category::all()->random())->create();
                    $data = ['id' => $product->id, 'purchase_quantity' => 5];
                    return [User::where('email', 'guest.user@email.com')->first(), $data, 403];
                },
            ],
        ];
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsersDataAndStatus
     */
    public function test_store_purchase_as_user($getData)
    {
        [$user, $data, $status] = $getData();

        $response = $this->actingAs($user)->from(route('purchases'))->post(
            route('purchases.store'),
            ['products' => [$data]],
        );

        if ($status == 200) {
            $response->assertSessionHas('success', 'Compra registrada exitosamente.');
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }
}
