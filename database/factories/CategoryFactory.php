<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category_name=$this->faker->sentence(2);
        return [
            'name'=>$category_name,
            'slug'=>Str::slug($category_name)
        ];
    }
}
