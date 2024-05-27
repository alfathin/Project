<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create(['name' => 'customer']);
        Role::create(['name' => 'admin']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'test',
            'image' => 'img/profile.png',
            'role_id' => 1,
            'password' => '123'
        ]);
        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'username' => 'test2',
            'image' => 'img/profile.png',
            'role_id' => 2,
            'password' => '123'
        ]);

        // Category::create([
        //     'category_name' => 'Makanan'
        // ]);

        // Category::create([
        //     'category_name' => 'Minuman'
        // ]);

        // Product::create([
        //     'product_name' => 'Seblak',
        //     'price' => 15000,
        //     'description' => 'Seblak Bikin Seuhah',
        //     'stock' => 50,
        //     'image' => 'https://i.imgur.com/MGorDUi.png',
        //     'category_id' => 1
        // ]);

        // Product::create([
        //     'product_name' => 'Japlak',
        //     'price' => 15000,
        //     'description' => 'Japlak Bikin Seuhah',
        //     'stock' => 50,
        //     'image' => 'https://i.imgur.com/MGorDUi.png',
        //     'category_id' => 1
        // ]);

        // Product::create([
        //     'product_name' => 'Ale Ale',
        //     'price' => 15000,
        //     'description' => 'Ale Ale Bikin Nyegerin',
        //     'stock' => 50,
        //     'image' => 'https://i.imgur.com/MGorDUi.png',
        //     'category_id' => 2
        // ]);

        // Product::create([
        //     'product_name' => 'Teh Gelas',
        //     'price' => 15000,
        //     'description' => 'Teh Gelas Bikin nyegerin',
        //     'stock' => 50,
        //     'image' => 'https://i.imgur.com/MGorDUi.png',
        //     'category_id' => 2
        // ]);
    }
}
