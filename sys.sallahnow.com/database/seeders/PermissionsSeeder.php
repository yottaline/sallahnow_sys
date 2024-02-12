<?php

namespace Database\Seeders;

use App\Models\User_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User_group::create([
            'user_group_name' => 'Admin',
            'user_group_privileges'  => 0.
        ]);

    }
}