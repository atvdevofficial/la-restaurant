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
    }
}
