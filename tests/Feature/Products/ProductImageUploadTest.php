<?php

namespace Tests\Feature\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
        ]);
    }

    public function test_create_a_product_with_image()
    {
        $category = Category::all()->random();

        $product = Product::factory()->make();
        $product->category()->associate($category);

        $superAdmin = User::where('email', 'testeo.test.55@gmail.com')->first();

        $response = $this->actingAs($superAdmin)->from(route('products.create'))->post(
            route('products.store'),
            Arr::add($product->toArray(), 'image', UploadedFile::fake()->image('image.jpg')),
        );

        $response->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Product created successfully.');
    }

    public function test_create_a_product_with_image_mime_not_allowed()
    {
        $category = Category::all()->random();

        $product = Product::factory()->make();
        $product->category()->associate($category);

        $superAdmin = User::where('email', 'testeo.test.55@gmail.com')->first();

        $response = $this->actingAs($superAdmin)->from(route('products.create'))
            ->post(
                route('products.store'),
                Arr::add($product->toArray(), 'image', UploadedFile::fake()->image('image.bmp')),
            );

        $response->assertRedirect(route('products.create'))
            ->assertSessionHasErrors([
                'image',
            ]);
    }

    public function test_create_a_product_with_image_size_not_allowed()
    {
        $category = Category::all()->random();

        $product = Product::factory()->make();
        $product->category()->associate($category);

        $superAdmin = User::where('email', 'testeo.test.55@gmail.com')->first();

        $response = $this->actingAs($superAdmin)->from(route('products.create'))
            ->post(
                route('products.store'),
                Arr::add($product->toArray(), 'image', UploadedFile::fake()->create('image.jpg', 513)),
            );

        $response->assertRedirect(route('products.create'))
            ->assertSessionHasErrors([
                'image',
            ]);
    }

    public function test_update_a_product_with_image()
    {
        $category = Category::all()->random();

        $product = Product::factory()->make();
        $product->category()->associate($category);
        $product->save();

        $superAdmin = User::where('email', 'testeo.test.55@gmail.com')->first();

        $response = $this->actingAs($superAdmin)->from(route('products.edit', ['product' => $product->id]))
            ->put(
                route('products.update', ['product' => $product->id]),
                Arr::add($product->toArray(), 'image', UploadedFile::fake()->image('image.jpg')),
            );

        $response->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Product updated successfully.');
    }

    public function test_update_a_product_with_image_mime_not_allowed()
    {
        $category = Category::all()->random();

        $product = Product::factory()->make();
        $product->category()->associate($category);
        $product->save();

        $superAdmin = User::where('email', 'testeo.test.55@gmail.com')->first();

        $response = $this->actingAs($superAdmin)->from(route('products.edit', ['product' => $product->id]))
            ->put(
                route('products.update', ['product' => $product->id]),
                Arr::add($product->toArray(), 'image', UploadedFile::fake()->image('image.bmp')),
            );

        $response->assertRedirect(route('products.edit', ['product' => $product->id]))
            ->assertSessionHasErrors([
                'image',
            ]);
    }

    public function test_update_a_product_with_image_size_not_allowed()
    {
        $category = Category::all()->random();

        $product = Product::factory()->make();
        $product->category()->associate($category);
        $product->save();

        $superAdmin = User::where('email', 'testeo.test.55@gmail.com')->first();

        $response = $this->actingAs($superAdmin)->from(route('products.edit', ['product' => $product->id]))
            ->put(
                route('products.update', ['product' => $product->id]),
                Arr::add($product->toArray(), 'image', UploadedFile::fake()->create('image.jpg', 513)),
            );

        $response->assertRedirect(route('products.edit', ['product' => $product->id]))
            ->assertSessionHasErrors([
                'image',
            ]);
    }
}
