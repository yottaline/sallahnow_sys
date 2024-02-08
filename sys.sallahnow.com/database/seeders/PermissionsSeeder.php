<?php

namespace Database\Seeders;

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
        // users
        // Permission::create(['name'  => 'view-users']);
        // Permission::create(['name'  => 'add-users']);
        // Permission::create(['name'  => 'update-users']);
        // Permission::create(['name'  => 'delete-users']);
        // technicians
        Permission::create(['name'  => 'list-technician']);
        Permission::create(['name'  => 'view-technician']);
        Permission::create(['name'  => 'add-technician']);
        Permission::create(['name'  => 'update-technician']);
        Permission::create(['name'  => 'delete-technician']);
    }
}