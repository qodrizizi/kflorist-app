<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Indoor',
                'description' => 'Bonsai yang cocok diletakkan di dalam ruangan dengan pencahayaan cukup.',
                'icon' => 'fas fa-tree',
                'color' => 'green',
            ],
            [
                'name' => 'Outdoor',
                'description' => 'Bonsai yang membutuhkan sinar matahari langsung dan sirkulasi udara luar.',
                'icon' => 'fas fa-sun',
                'color' => 'orange',
            ],
            [
                'name' => 'Premium',
                'description' => 'Koleksi bonsai eksklusif dengan nilai seni dan umur yang tinggi.',
                'icon' => 'fas fa-star',
                'color' => 'purple',
            ],
            [
                'name' => 'Bibit',
                'description' => 'Bakal bonsai atau bibit unggul untuk pemula maupun kolektor.',
                'icon' => 'fas fa-seedling',
                'color' => 'teal',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
