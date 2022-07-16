<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        $images = [
            '00694-01.jpg',
            '01061-01.jpg',
            '01606-01.jpg',
            '01726-01.jpg',
            '02137-01.jpg',
            '02378-01.jpg',
            '02434-01.jpg',
            '02655-01.jpg',
            '02758-01.jpg',
            '02893-01.jpg',
            '03489-01.jpg',
            '04293-01.jpg',
            '04297-01.jpg',
            '05359-01.jpg',
            '05723-01.jpg',
            '07290-01.jpg',
            '07615-01.jpg',
            '07837-01.jpg',
            '09429-01.jpg',
            '10214-01.jpg',
            '10940-01.jpg',
            '11346-01.jpg',
            '11689-01.jpg',
            '12483-01.jpg',
            '12506-01.jpg',
            '13836-01.jpg',
            '14101-01.jpg',
            '14413-01.jpg',
            '14547-01.jpg',
            '15164-01.jpg',
            '16585-01.jpg',
            '16958-01.jpg',
            '17526-01.jpg',
            '17570-01.jpg',
            '17647-01.jpg',
            '17697-01.jpg',
            '17915-01.jpg',
            '19100-01.jpg',
            '19101-01.jpg',
            '19254-01.jpg',
            '19447-01.jpg',
            '19534-01.jpg',
            '19928-01.jpg',
            '20008-01.jpg',
            '20217-01.jpg',
            '21588-01.jpg',
            '22150-01.jpg',
            '22532-01.jpg',
            '22649-01.jpg',
            '22772-01.jpg',
        ];

        foreach ($images as $index => $image) {
            $product = Product::factory()->make(['url_image' => "storage/products/$image"]);
            $product->category()->associate($categories->random());
            $product->save();
        }
    }
}
