<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Public Route Tests
     */
    public function testPublicProductCategoryIndex() {
        factory(\App\ProductCategory::class, 5)->create();

        $this->getJson(route('productCategories.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'name'
        ]]);
    }

    public function testPublicProductCategoryShow() {
        $productCategory = factory(\App\ProductCategory::class)->create();

        $this->getJson(route('productCategories.show', ['productCategory' => $productCategory->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name'
        ]);
    }

    /**
     * Administrator Tests
     */
    public function testPublicProductCategoryStore() {
        $productCategoryData = [
            'name' => $this->faker->word
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->postJson(route('productCategories.store', $productCategoryData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'name'
        ]);
    }

    public function testPublicProductCategoryUpdate() {
        $productCategory = factory(\App\ProductCategory::class)->create();

        $productCategoryData = [
            'productCategory' => $productCategory->id,
            'name' => $productCategory->name
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->putJson(route('productCategories.update', $productCategoryData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name'
        ]);
    }

    public function testPublicProductCategoryDestroy() {
        $productCategory = factory(\App\ProductCategory::class)->create();

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->deleteJson(route('productCategories.destroy', ['productCategory' => $productCategory->id]))
        ->assertStatus(204);
    }
}
