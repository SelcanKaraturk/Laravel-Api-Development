<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product_name=$this->faker->sentence(3);
        return [
            'name'=>$product_name,
            'slug'=>Str::slug($product_name),
            'description'=>$this->faker->paragraph(2),
            'price'=>mt_rand(10,100)/10,

        ];
    }
}
