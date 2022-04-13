<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       /* $this->call([
            ProductSeeder::class,
            CategorySeeder::class
        ]);*/
         \App\Models\User::factory(10)->create();
         \App\Models\Product::factory(10)->create();
         \App\Models\Category::factory(10)->create();

        DB::table('category_product')->insert([
            'product_id'=>1,
            'category_id'=>1
        ]);
        DB::table('category_product')->insert([
            'product_id'=>1,
            'category_id'=>2
        ]);
        DB::table('category_product')->insert([
            'product_id'=>2,
            'category_id'=>1
        ]);
        DB::table('category_product')->insert([
            'product_id'=>2,
            'category_id'=>2
        ]);
        DB::table('category_product')->insert([
            'product_id'=>2,
            'category_id'=>3
        ]);


    }
}
