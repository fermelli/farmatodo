<?php

namespace Tests\Feature\RoleManagement;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RoleAttachAndDetachTest extends TestCase
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

    public function providerForSetRoles()
    {
        return [
            'you are already an administrator' => [
                function () {
                    $administratorRole = Role::where('name', 'Administrator')->first();
                    $user = User::factory()
                        ->hasAttached($administratorRole)
                        ->create();
                    return [
                        $user,
                        $administratorRole,
                        400,
                        'Rol ' . __($administratorRole->name) . ' ya esta establecido',
                    ];
                },
            ],
            'you are already a user' => [
                function () {
                    $userRole = Role::where('name', 'User')->first();
                    $user = User::factory()
                        ->hasAttached($userRole)
                        ->create();
                    return [
                        $user,
                        $userRole,
                        400,
                        'Rol ' . __($userRole->name) . ' ya esta establecido',
                    ];
                },
            ],
            'you are already a guest' => [
                function () {
                    $guestRole = Role::where('name', 'Guest')->first();
                    $user = User::factory()
                        ->hasAttached($guestRole)
                        ->create();
                    return [
                        $user,
                        $guestRole,
                        400,
                        'Rol ' . __($guestRole->name) . ' ya esta establecido',
                    ];
                },
            ],
            'established admin role' => [
                function () {
                    $administratorRole = Role::where('name', 'Administrator')->first();
                    $user = User::factory()->create();
                    return [
                        $user,
                        $administratorRole,
                        201,
                        __('Established role') . ': ' . __($administratorRole->name),
                    ];
                },
            ],
            'established user role' => [
                function () {
                    $userRole = Role::where('name', 'User')->first();
                    $user = User::factory()->create();
                    return [
                        $user,
                        $userRole,
                        201,
                        __('Established role') . ': ' . __($userRole->name),
                    ];
                },
            ],
            'established guest role' => [
                function () {
                    $guestRole = Role::where('name', 'Guest')->first();
                    $user = User::factory()->create();
                    return [
                        $user,
                        $guestRole,
                        201,
                        __('Established role') . ': ' . __($guestRole->name),
                    ];
                },
            ],
        ];
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerForSetRoles
     */
    public function test_set_a_roles_for_users_as_a_super_admin($getData)
    {
        [$user, $role, $status, $message] = $getData();

        $response = $this->actingAs($this->superAdmin)
            ->post(route('users.roles.store', ['user' => $user->id, 'role' => $role->id]));

        $response->assertStatus($status)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('message', $message)
                    ->where('role', $role)
                    ->where('user', $user)
            );
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerForSetRoles
     */
    public function test_cannot_set_a_roles_for_users_as_a_non_super_admin($getData)
    {
        [$user, $role, $status, $message] = $getData();

        $response = $this->actingAs($this->noSuperAdmin)
            ->post(route('users.roles.store', ['user' => $user->id, 'role' => $role->id]));

        $response->assertStatus(403);
    }

    public function providerForRemoveRoles()
    {
        return [
            'unestablished admin role' => [
                function () {
                    $administratorRole = Role::where('name', 'Administrator')->first();
                    $user = User::factory()->create();
                    return [
                        $user,
                        $administratorRole,
                        400,
                        'Rol ' . __($administratorRole->name) . ' no esta establecido',
                    ];
                },
            ],
            'unestablished user role' => [
                function () {
                    $userRole = Role::where('name', 'User')->first();
                    $user = User::factory()->create();
                    return [
                        $user,
                        $userRole,
                        400,
                        'Rol ' . __($userRole->name) . ' no esta establecido',
                    ];
                },
            ],
            'unestablished guest role' => [
                function () {
                    $guestRole = Role::where('name', 'Guest')->first();
                    $user = User::factory()->create();
                    return [
                        $user,
                        $guestRole,
                        400,
                        'Rol ' . __($guestRole->name) . ' no esta establecido',
                    ];
                },
            ],
            'default guest role' => [
                function () {
                    $guestRole = Role::where('name', 'Guest')->first();
                    $user = User::factory()
                        ->hasAttached($guestRole)
                        ->create();
                    return [
                        $user,
                        $guestRole,
                        400,
                        'Rol ' . __($guestRole->name) . ' no se puede eliminar (rol por defecto)',
                    ];
                },
            ],
            'removed admin role' => [
                function () {
                    $administratorRole = Role::where('name', 'Administrator')->first();
                    $user = User::factory()
                        ->hasAttached($administratorRole)
                        ->create();
                    return [
                        $user,
                        $administratorRole,
                        200,
                        __('Role removed') . ': ' . __($administratorRole->name),
                    ];
                },
            ],
            'removed user role' => [
                function () {
                    $userRole = Role::where('name', 'User')->first();
                    $user = User::factory()
                        ->hasAttached($userRole)
                        ->create();
                    return [
                        $user,
                        $userRole,
                        200,
                        __('Role removed') . ': ' . __($userRole->name),
                    ];
                },
            ],
        ];
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerForRemoveRoles
     */
    public function test_remove_a_roles_for_users_as_a_super_admin($getData)
    {
        [$user, $role, $status, $message] = $getData();

        $response = $this->actingAs($this->superAdmin)
            ->delete(route('users.roles.delete', ['user' => $user->id, 'role' => $role->id]));

        $response->assertStatus($status)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('message', $message)
                    ->where('role', $role)
                    ->where('user', $user)
            );
    }

    /**
     * Test with data from dataProvider
     *
     * @dataProvider providerForRemoveRoles
     */
    public function test_cannot_remove_a_roles_for_users_as_a_non_super_admin($getData)
    {
        [$user, $role, $status, $message] = $getData();

        $response = $this->actingAs($this->noSuperAdmin)
            ->delete(route('users.roles.delete', ['user' => $user->id, 'role' => $role->id]));

        $response->assertStatus(403);
    }
}
