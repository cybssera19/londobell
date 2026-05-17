<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class AdminAndCategorySeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Bright Noa',
            'email' => 'admin.noa@gmail.com',
            'password' => Hash::make('secret123'),
            'phone' => '081234567890',
            'role' => 'admin',
        ]);

        Category::create(['category_name' => 'Makanan']);
        Category::create(['category_name' => 'Minuman']);
        Category::create(['category_name' => 'Elektronik']);
    }
}
