<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

        User::factory()->create([
            'name' => 'Tri Kusuma Atmaja',
            'email' => 'trie168@gmail.com',
            'password' => Hash::make('123456')
        ]);

        // category factory 2
        Category::factory(2)->create();
    }
}
