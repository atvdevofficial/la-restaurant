<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Public Route Tests
     */
    public function testPublicProductIndex() {
        factory(\App\Product::class, 5)->create();

        $this->getJson(route('products.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'name', 'description',
            'price', 'image_link'
        ]]);
    }

    public function testPublicProductShow() {
        $product = factory(\App\Product::class)->create();

        $this->getJson(route('products.show', ['product' => $product->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name', 'description',
            'price', 'image_link', 'product_categories'
        ]);
    }

    /**
     * Administrator Tests
     */
    public function testPublicProductStore() {
        $productCategory = factory(\App\ProductCategory::class)->create();

        $productData = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => random_int(100, 9999),
            'image_link' => $this->faker->imageUrl,

            'product_categories' => [
                $productCategory->id
            ]
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->postJson(route('products.store', $productData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'name', 'description',
            'price', 'image_link', 'product_categories'
        ]);
    }

    public function testPublicProductUpdate() {
        $productCategory = factory(\App\ProductCategory::class)->create();

        $product = factory(\App\Product::class)->create();

        $productData = [
            'product' => $product->id,
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => random_int(100, 9999),
            'image' => $this->faker->imageUrl,

            'product_categories' => [
                $productCategory->id
            ]
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->putJson(route('products.update', $productData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name', 'description',
            'price', 'image_link', 'product_categories'
        ]);
    }

    public function testPublicProductDestroy() {
        $product = factory(\App\Product::class)->create();

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->deleteJson(route('products.destroy', ['product' => $product->id]))
        ->assertStatus(204);
    }
}
