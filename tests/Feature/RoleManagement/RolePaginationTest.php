<?php

namespace Tests\Feature\RoleManagement;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RolePaginationTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $noSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, UserSeeder::class]);
        $this->superAdmin = User::where('email', 'testeo.test.55@gmail.com')->first();
        $this->noSuperAdmin = User::where('email', 'no.super.admin@email.com')->first();
    }

    public function test_role_management_screen_can_be_rendered_for_super_admin()
    {
        $response = $this->actingAs($this->superAdmin)->get(route('roles.management'));

        $response->assertStatus(200);
    }

    public function test_role_admin_screen_cannot_be_rendered_for_other_than_super_admins()
    {
        $response = $this->actingAs($this->noSuperAdmin)->get(route('roles.management'));

        $response->assertStatus(403);
    }

    public function test_get_all_roles_except_super_admin_role_for_super_admin()
    {
        $response = $this->actingAs($this->superAdmin)->getJson(route('roles.index'));

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(3)
            );
    }

    public function test_cannot_get_roles_for_non_super_admin_users()
    {
        $response = $this->actingAs($this->noSuperAdmin)->getJson(route('roles.index'));

        $response->assertStatus(403);
    }

    public function test_get_user_roles_without_query_params_as_super_administrator()
    {
        $response = $this->actingAs($this->superAdmin)->getJson(route('users.roles'));

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data', 10)
                    ->where('current_page', 1)
                    ->where('from', 1)
                    ->where('per_page', 10)
                    ->etc()
            );
    }

    public function test_get_user_roles_without_query_params_as_non_super_administrator_user()
    {
        $response = $this->actingAs($this->noSuperAdmin)->getJson(route('users.roles'));

        $response->assertStatus(403);
    }

    public function providerPagesAndSizes()
    {
        return array(
            'without page and size 5' => [null, 5],
            'without page and size 10' => [null, 10],
            'without page and size 15' => [null, 15],
            'page out of range (<) and size 5' => [-1, 5],
            'page out of range (<) and size 10' => [-1, 10],
            'page out of range (<) and size 15' => [-1, 15],
            'page 1 and without size' => [1, null],
            'page 1 and without size' => [1, null],
            'page 1 and without size' => [1, null],
            'page 1 and size 5' => [1, 5],
            'page 1 and size 10' => [1, 10],
            'page 1 and size 15' => [1, 15],
            'last page (10) for size 5' => [10, 5],
            'last page (5) for size 10' => [5, 10],
            'last page (4) for size 15' => [4, 15],
            'page out of range (>) and size 5' => [11, 5],
            'page out of range (>) and size 10' => [6, 10],
            'page out of range (>) and size 15' => [5, 15],
        );
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerPagesAndSizes
     */
    public function test_get_user_roles_with_query_params_as_super_administrator($page, $size)
    {
        $expectedTotal = User::whereNot('id', $this->superAdmin->id)->get()->count();
        $expectedSize = $size == null ? 10 : $size;
        $expecteLastPage = (int) ceil($expectedTotal / $expectedSize);
        $expectedCurrentPage = $page == null || $page <= 0 ? 1 : $page;

        if ($expectedCurrentPage <= $expecteLastPage) {
            $condition = ($expectedTotal % $expectedSize) > 0 && $expectedCurrentPage == $expecteLastPage;
            $dataLength = $condition ? $expectedTotal % $expectedSize : $expectedSize;
            $expectedFrom = ($expectedSize * ($expectedCurrentPage - 1)) + 1;
            $expectedTo = $condition ?
                ($expectedSize * ($expectedCurrentPage - 1)) + ($expectedTotal % $expectedSize)
                : $expectedSize * $expectedCurrentPage;
        } else {
            $dataLength = 0;
            $expectedFrom = null;
            $expectedTo = null;
        }

        if ($page != null && $size != null) {
            $route = route('users.roles', ['page' => $page, 'size' => $size]);
        } else {
            if ($page == null) {
                $route = route('users.roles', ['size' => $size]);
            }

            if ($size == null) {
                $route = route('users.roles', ['page' => $page]);
            }
        }

        $response = $this->actingAs($this->superAdmin)->getJson($route);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('current_page', $expectedCurrentPage)
                    ->has('data', $dataLength)
                    ->where('from', $expectedFrom)
                    ->where('last_page', $expecteLastPage)
                    ->where('per_page', $expectedSize)
                    ->where('to', $expectedTo)
                    ->where('total', $expectedTotal)
                    ->etc()
            );
    }
}
