<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'id' => (string) Str::uuid(),
            'name' => 'Administrator',
            'email' => 'admin@blackspot.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
