<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }

    public function providerUsers()
    {
        return [
            'super-admin' => [
                function () {
                    return [User::where('email', 'testeo.test.55@gmail.com')->first(), 200];
                },
            ],
            'admin' => [
                function () {
                    return [User::where('email', 'no.super.admin@email.com')->first(), 200];
                },
            ],
            'user' => [
                function () {
                    return [User::where('email', 'user.user@email.com')->first(), 403];
                },
            ],
            'guest' => [
                function () {
                    return [User::where('email', 'guest.user@email.com')->first(), 403];
                },
            ],
        ];
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_read_a_single_product_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $product = Product::all()->random();

        $response = $this->actingAs($user)->get(
            route('products.show', ['product' => $product->id])
        );

        if ($status == 200) {
            $response->assertSee($status)
                ->assertSee($product->name)
                ->assertSee($product->type)
                ->assertSee($product->brand)
                ->assertSee($product->price)
                ->assertSee($product->quantity);
        }

        if ($status == 403) {
            $response->assertSee($status);
        }
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_product_create_screen_can_be_rendered_for_user($getData)
    {
        [$user, $status] = $getData();

        $categories = Category::all();

        $response = $this->actingAs($user)->get(route('products.create'));

        if ($status == 200) {
            $response->assertStatus($status)
                ->assertSee($categories->pluck('name')->toArray());
        }

        $response->assertStatus($status);
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_create_a_single_product_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $category = Category::all()->random();

        $product = Product::factory()->make();
        $product->category()->associate($category);

        $response = $this->actingAs($user)->from(route('products.create'))->post(
            route('products.store'),
            $product->toArray(),
        );

        if ($status == 200) {
            $response->assertRedirect(route('products.index'))
                ->assertSessionHas('success', 'Product created successfully.');
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_create_a_single_product_with_empty_inputs_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $response = $this->actingAs($user)->from(route('products.create'))
            ->post(
                route('products.store'),
                [
                    'name' => null,
                    'type' => null,
                    'brand' => null,
                    'price' => null,
                    'quantity' => null,
                    'category_id' => null,
                ],
            );

        if ($status == 200) {
            $response->assertRedirect(route('products.create'))
                ->assertSessionHasErrors([
                    'name',
                    'type',
                    'brand',
                    'price',
                    'quantity',
                    'category_id',
                ]);
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_product_update_screen_can_be_rendered_for_user($getData)
    {
        [$user, $status] = $getData();

        $product = Product::all()->random();

        $categories = Category::all();

        $response = $this->actingAs($user)->get(
            route('products.edit', ['product' => $product->id])
        );

        if ($status == 200) {
            $response->assertSee($status)
                ->assertSee($product->name)
                ->assertSee($product->type)
                ->assertSee($product->brand)
                ->assertSee($product->price)
                ->assertSee($product->quantity)
                ->assertSee($product->category_id)
                ->assertSee($categories->pluck('name')->toArray());
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_update_a_single_product_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $productId = Product::all()->random()->id;

        $category = Category::all()->random();

        $updatedProduct = Product::factory()->make();
        $updatedProduct->category()->associate($category);

        $response = $this->actingAs($user)->from(route('products.edit', $productId))->put(
            route('products.update', $productId),
            $updatedProduct->toArray(),
        );

        if ($status == 200) {
            $response->assertRedirect(route('products.index'))
                ->assertSessionHas('success', 'Product updated successfully.');
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_update_a_single_product_with_empty_inputs_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $productId = Product::all()->random()->id;

        $response = $this->actingAs($user)->from(route('products.edit', $productId))
            ->put(
                route('products.update', $productId),
                [
                    'name' => null,
                    'type' => null,
                    'brand' => null,
                    'price' => null,
                    'quantity' => null,
                ],
            );

        if ($status == 200) {
            $response->assertRedirect(route('products.edit', $productId))
                ->assertSessionHasErrors([
                    'name',
                    'type',
                    'brand',
                    'price',
                    'quantity',
                ]);
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_delete_a_single_product_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $productId = Product::all()->random()->id;

        $response = $this->actingAs($user)->delete(
            route('products.destroy', $productId)
        );

        if ($status == 200) {
            $response->assertRedirect(route('products.index'))
                ->assertSessionHas('success', 'Product deleted successfully.');
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }
}
