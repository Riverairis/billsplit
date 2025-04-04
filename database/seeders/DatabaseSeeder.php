<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create categories
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
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Create test users
        DB::table('users')->insert([
            [
                'last_name' => 'Admin',
                'first_name' => 'System',
                'nickname' => 'admin',
                'email' => 'admin@billsplit.com',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'account_type' => 'premium',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'last_name' => 'Doe',
                'first_name' => 'John',
                'nickname' => 'johndoe',
                'email' => 'john@example.com',
                'username' => 'john',
                'password' => Hash::make('password'),
                'account_type' => 'standard',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}