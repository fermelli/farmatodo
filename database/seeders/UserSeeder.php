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
        $userRole = $roles->firstWhere('name', 'User');
        $guestRole = $roles->firstWhere('name', 'Guest');

        User::factory()
            ->hasAttached([$superAdministratorRole, $guestRole])
            ->create([
                'name' => 'Testeo Test',
                'email' => 'testeo.test.55@gmail.com',
            ]);

        User::factory()->count(30)
            ->hasAttached([$userRole, $guestRole])
            ->create();
    }
}
