<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText(100),
        'parent_id'     =>  1,
        'menu'          =>  1,
    ];
});

// class UserFactory extends Factory
// {
//     /**
//      * Define the model's default state.
//      *
//      * @return array<string, mixed>
//      */
//     public function definition()
//     {
//         return [
//             'name' => fake()->name(),
//             'description' => fake()->realText(100),
//             'parent_id'     =>  null,
//             'menu'          =>  0,
//         ];
//     }
// }
