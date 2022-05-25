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
        $administratorRole = $roles->firstWhere('name', 'Administrator');
        $userRole = $roles->firstWhere('name', 'User');

        User::factory()
            ->hasAttached($administratorRole)
            ->create([
                'name' => 'Testeo Test',
                'email' => 'testeo.test.55@gmail.com',
            ]);

        User::factory()->count(10)
            ->hasAttached($userRole)
            ->create();
    }
}
