<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Food & Dining',
            'Utilities',
            'Shopping',
            'Education',
            'Personal Care',
            'Travel',
            'Entertainment',
            'Health & Fitness',
            'Gifts & Donations',
            'Other'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
