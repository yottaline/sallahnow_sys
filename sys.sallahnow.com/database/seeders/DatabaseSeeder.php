<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\PermissionsSeeder;

use function Pest\Laravel\call;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call(PermissionsSeeder::class);
        \App\Models\User::create([
            'user_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('1234567'),
            'user_mobile' => '0122356718',
            'user_group' => 1,
            'user_create' => now()
        ]);
    }
}