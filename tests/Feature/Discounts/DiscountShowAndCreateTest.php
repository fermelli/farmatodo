<?php

namespace Tests\Feature\Discounts;

use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class DiscountShowAndCreateTest extends TestCase
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
    public function test_read_a_single_discount_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $products = Product::all()->random(rand(3, 5));

        $discount = Discount::factory()->hasAttached($products)->create();

        $response = $this->actingAs($user)->get(
            route('discounts.show', ['discount' => $discount->id])
        );

        if ($status == 200) {
            $response->assertSee($status)
                ->assertSee($discount->name)
                ->assertSee($discount->percentage)
                ->assertSee($discount->start_date)
                ->assertSee($discount->end_date);
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
    public function test_discount_create_screen_can_be_rendered_for_user($getData)
    {
        [$user, $status] = $getData();

        $response = $this->actingAs($user)->get(route('discounts.create'));

        $response->assertStatus($status);
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_create_a_single_discount_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $products = Product::all()->random(rand(3, 5));

        $discount = Discount::factory()->make();

        $productsIds = $products->map(function ($product) {
            return ['id' => $product->id];
        });

        $response = $this->actingAs($user)->from(route('discounts.create'))->post(
            route('discounts.store'),
            Arr::add($discount->toArray(), 'products', $productsIds->toArray()),
        );

        if ($status == 200) {
            $response->assertRedirect(route('discounts.index'))
                ->assertSessionHas('success', 'Descuento creado con éxito.');
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
    public function test_create_a_single_discount_with_empty_inputs_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $response = $this->actingAs($user)->from(route('discounts.create'))
            ->post(
                route('discounts.store'),
                [
                    'name' => null,
                    'percentage' => null,
                    'start_date' => null,
                    'end_date' => null,
                    'products' => null,
                ],
            );

        if ($status == 200) {
            $response->assertRedirect(route('discounts.create'))
                ->assertSessionHasErrors([
                    'name',
                    'percentage',
                    'start_date',
                    'end_date',
                    'products',
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
    public function test_soft_delete_a_single_discount_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $discount = Discount::factory()->create();

        $response = $this->actingAs($user)->delete(
            route('discounts.destroy', $discount->id)
        );

        if ($status == 200) {
            $response->assertRedirect(route('discounts.index'))
                ->assertSessionHas('success', 'Descuento desactivado con éxito.');
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
    public function test_restore_a_single_discount_as_a_user($getData)
    {
        [$user, $status] = $getData();

        $discount = Discount::factory()->create([
            'deleted_at' => now(),
        ]);

        $response = $this->actingAs($user)->post(
            route('discounts.restore', $discount->id)
        );

        if ($status == 200) {
            $response->assertRedirect(route('discounts.index'))
                ->assertSessionHas('success', 'Descuento activado con éxito.');
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }
}
