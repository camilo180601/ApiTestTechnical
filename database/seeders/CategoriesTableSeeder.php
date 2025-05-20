<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'id' => 1,
            'name' => 'Tecnologia',
            'description' => 'Productos de tecnologia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
