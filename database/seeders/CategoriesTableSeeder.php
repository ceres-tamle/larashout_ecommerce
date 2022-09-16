<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'          =>  'Root',
            'description'   =>  'This is the root category, don\'t delete this one',
            'parent_id'     =>  null,
            'menu'          =>  0,
            // 'name' => fake()->name,
            // 'description' => fake()->realText(100),
            // 'parent_id'     =>  1,
            // 'menu'          =>  0,
        ]);

        // factory(App\Models\Supplier::class, 10)->create();
        \App\Models\Category::factory()->time(10)->create();
    }
}
