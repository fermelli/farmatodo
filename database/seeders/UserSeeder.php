<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();
        $superAdministratorRole = $roles->firstWhere('name', 'Super Administrator');
        $administratorRole = $roles->firstWhere('name', 'Administrator');
        $userRole = $roles->firstWhere('name', 'User');
        $guestRole = $roles->firstWhere('name', 'Guest');

        User::factory()
            ->hasAttached($superAdministratorRole)
            ->create([
                'name' => 'Testeo Test',
                'email' => 'testeo.test.55@gmail.com',
            ]);

        User::factory()
            ->hasAttached([$administratorRole, $userRole, $guestRole])
            ->create([
                'name' => 'No Super Admin',
                'email' => 'no.super.admin@email.com',
            ]);

        User::factory()->count(8)
            ->hasAttached([$administratorRole, $userRole, $guestRole])
            ->create();

        User::factory()
            ->hasAttached([$userRole, $guestRole])
            ->create([
                'name' => 'User User',
                'email' => 'user.user@email.com',
            ]);

        User::factory()->count(29)
            ->hasAttached([$userRole, $guestRole])
            ->create();

        User::factory()
            ->hasAttached($guestRole)
            ->create([
                'name' => 'Guest User',
                'email' => 'guest.user@email.com',
            ]);

        User::factory()->count(9)
            ->hasAttached($guestRole)
            ->create();
    }
}
