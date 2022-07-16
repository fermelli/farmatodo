<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_read_a_single_purchase_belonging_to_the_authenticated_user()
    {
        $user = User::where('email', 'user.user@email.com')->first();

        $products = Product::factory()->count(5)
            ->for(Category::all()->random())->create();

        $purchase = Purchase::factory()->for($user)
            ->hasAttached($products, ['quantity' => 1, 'price' => 100])->create();

        $response = $this->actingAs($user)->get(
            route('purchases.show', $purchase->id)
        );

        $response->assertSee(200)
            ->assertSee($products->get(0)->name)
            ->assertSee($products->get(1)->name)
            ->assertSee($products->get(2)->name)
            ->assertSee($products->get(3)->name)
            ->assertSee($products->get(4)->name);
    }

    public function test_read_a_single_purchase_that_does_not_belong_to_the_authenticated_user()
    {
        $user = User::where('email', 'user.user@email.com')->first();

        $otherUser = User::factory()->hasAttached(Role::where('name', 'User')->first())->create();

        $products = Product::factory()->count(5)
            ->for(Category::all()->random())->create();

        $purchase = Purchase::factory()->for($otherUser)
            ->hasAttached($products, ['quantity' => 1, 'price' => 100])->create();

        $response = $this->actingAs($user)->get(
            route('purchases.show', $purchase->id)
        );

        $response->assertSee(403);
    }

    public function providerUsers()
    {
        return [
            'super-admin' => [
                function () {
                    return [User::where('email', 'testeo.test.55@gmail.com')->first(), 403];
                },
            ],
            'admin' => [
                function () {
                    return [User::where('email', 'admin@email.com')->first(), 403];
                },
            ],
            'user' => [
                function () {
                    return [User::where('email', 'user.user@email.com')->first(), 200];
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
    public function test_purchases_pagination_for_user($getData)
    {
        [$user, $status] = $getData();

        $products = Product::factory()
            ->for(Category::all()->random())->create();

        $purchases = Purchase::factory()->count(5)->for($user)
            ->hasAttached($products, ['quantity' => 1, 'price' => 100])->create();

        $response = $this->actingAs($user)->get(route('purchases.all'));

        if ($status == 200) {
            $response->assertSee($status)
                ->assertSee($purchases->get(0)->name)
                ->assertSee($purchases->get(1)->name)
                ->assertSee($purchases->get(2)->name)
                ->assertSee($purchases->get(3)->name)
                ->assertSee($purchases->get(4)->name);
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }
}
