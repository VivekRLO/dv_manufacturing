<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin',
            'phone' => '9876543210',
            'password' => Hash::make('12345678'),
            'role' => 0,
            'type' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);
        DB::table('users')->insert([
            'name' => 'aayush',
            'email' => 'aayush@aayush',
            'phone' => '9861587505',
            'password' => Hash::make('12345678'),
            'role' => 5,
            'type' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('users')->insert([
            'name' => 'sid',
            'email' => 'sid@sid',
            'phone' => '9823036454',
            'password' => Hash::make('12345678'),
            'role' => 5,
            'type' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);
        DB::table('users')->insert([
            'name' => 'anamol',
            'email' => 'anamol@anamol',
            'phone' => '9861165687',
            'password' => Hash::make('12345678'),
            'role' => 5,
            'type' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);
        
        // for ($i=0; $i < 1000; $i++) { DB::table('sales')->insert([
        //     'sales_officer_id' => rand(2,5),
        //     'distributor_id' => rand(1,5),
        //     'batch_id' => rand(1,3),
        //     'product_id' => rand(1,11),
        //     'quantity' => rand(10,5000),
        //     'outlet_id' => rand(1,10),
        //     'sold_at' => Carbon::now()->startOfMonth()->addDays(rand(1,30))->addDays(rand(1,30)),
        //     'sales_officer_id' => rand(2,5),
        //     'created_at' => Carbon::now()->startOfMonth()->addDays(rand(1,30))->addDays(rand(1,30)),
        //     'updated_at' => Carbon::now()->startOfMonth()->addDays(rand(1,30))->addDays(rand(1,30)),

        // ]);
        //}

}
}
