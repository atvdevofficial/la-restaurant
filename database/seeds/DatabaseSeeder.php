<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Customer Model
        $customerUser = factory(\App\User::class)->create(['email' => 'customer@mr.com', 'role' => 'CUSTOMER']);
        $customer = factory(\App\Customer::class)->create(['user_id' => $customerUser->id]);

        // Products
        for ($i=0; $i < 5; $i++) {
            $productCategory = factory(\App\ProductCategory::class)->create();
            $product = factory(\App\Product::class)->create();
            $product->productCategories()->sync([$productCategory->id]);
        }

    }
}
