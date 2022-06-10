<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        $users = Role::where('name', 'User')->first()->users;

        Purchase::factory()->count(100)->make()
            ->each(function ($purchase) use ($users, $products) {
                $purchase->user()->associate($users->random());
                $purchase->save();

                $products->random(rand(1, 5))->each(function ($product) use ($purchase) {
                    $purchase->products()->attach($product->id, ['quantity' => rand(1, 5)]);
                });
            });
    }
}
