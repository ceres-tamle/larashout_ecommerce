<?php

namespace Database\Seeders;

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
        #change
        // $this->call(AdminsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        #change
    }
}
