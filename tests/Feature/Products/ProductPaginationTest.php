<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPaginationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
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
    public function test_products_index_screen_can_be_rendered_for_user($getData)
    {
        [$user, $status] = $getData();

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus($status);
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerUsers
     */
    public function test_products_pagination_for_user($getData)
    {
        $products = Product::latest()->paginate(5);

        [$user, $status] = $getData();

        $response = $this->actingAs($user)->get(route('products.index'));

        if ($status == 200) {
            $response->assertSee($status)
                ->assertSee([$products->get(0)->name, $products->get(0)->category->name])
                ->assertSee([$products->get(1)->name, $products->get(1)->category->name])
                ->assertSee([$products->get(2)->name, $products->get(2)->category->name])
                ->assertSee([$products->get(3)->name, $products->get(3)->category->name])
                ->assertSee([$products->get(4)->name, $products->get(4)->category->name]);
        }

        if ($status == 403) {
            $response->assertStatus($status);
        }
    }
}
