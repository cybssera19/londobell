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
        // 1. Memasukkan 1 Data Admin Default
        User::create([
            'name' => 'Bright Noa',            // Nama Lengkap Admin (bebas)
            'email' => 'admin.noa@gmail.com',   // Format wajib @gmail.com
            'password' => Hash::make('secret123'), // Password disandikan, minimal 6-12 huruf
            'phone' => '081234567890',         // Nomor HP wajib diawali 08
            'role' => 'admin',                 // Kita set role-nya sebagai admin
        ]);

        // 2. Memasukkan Kategori Barang Awal (Minimal satu kategori)
        Category::create(['category_name' => 'Makanan']);
        Category::create(['category_name' => 'Minuman']);
        Category::create(['category_name' => 'Elektronik']);
    }
}
