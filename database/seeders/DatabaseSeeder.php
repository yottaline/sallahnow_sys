<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Support\Str;

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
            'user_name' => 'Tech. Support',

            'user_email' => 'support@yottaline.com',
            'user_password' => Hash::make('Support@Yottaline'),
            'user_mobile' => '01033306468',
            'user_group' => 1,
            'user_create' => now()
        ]);
    }
}