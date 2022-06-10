<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
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
    public function test_report_screen_can_be_rendered_for_user($getData)
    {
        [$user, $status] = $getData();

        $response = $this->actingAs($user)->get(route('report'));

        $response->assertStatus($status);
    }

    public function test_view_purchase_report_between_dates()
    {
        $admin = User::where('email', 'admin@email.com')->first();
        $user = User::where('email', 'user.user@email.com')->first();
        $purchases = Purchase::factory()->count(5)->for($user)
            ->hasAttached(Product::all()->random(3), [
                'quantity' => 3,
            ])->create([
                'created_at' => '2022-05-02',
            ]);
        $response = $this->actingAs($admin)->get(route('report', [
            'start_date' => '2022-05-01',
            'end_date' => '2022-05-04',
        ]));
        $response->assertSee(200)
            ->assertSee($purchases->get(0)->created_at)
            ->assertSee($purchases->get(1)->created_at)
            ->assertSee($purchases->get(2)->created_at)
            ->assertSee($purchases->get(3)->created_at)
            ->assertSee($purchases->get(4)->created_at);
    }
}
