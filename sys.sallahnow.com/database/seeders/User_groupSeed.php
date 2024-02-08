<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class User_groupSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name'  => 'Admin']);
        Role::create(['name'  => 'Sales']);
        Role::create(['name'  => 'Users']);
    }
}