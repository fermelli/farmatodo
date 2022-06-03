<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Farmacia'],
            ['name' => 'Cósmetica y Belleza'],
            ['name' => 'Mamá y Bebé'],
            ['name' => 'Juguetería'],
            ['name' => 'Cuidado Personal'],
            ['name' => 'Alimentos y Bebidas'],
            ['name' => 'Hogar'],
        ]);
    }
}
