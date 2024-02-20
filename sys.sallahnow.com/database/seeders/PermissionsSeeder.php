<?php

namespace Database\Seeders;

use App\Models\Package;
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
            'user_group_privileges'  => '["add-users","view-users","update-users"]'
        ]);

        Package::create([
            'type'     => 1,
            'period'   => 0,
            'cost'     => 0,
            'points'   => 0,
            'priv'     => ''
        ]);
        Package::create([
            'type'     => 2,
            'period'   => 1,
            'cost'     => 10,
            'points'   => 100,
            'priv'     => ''
        ]);
        Package::create([
            'type'     => 2,
            'period'   => 6,
            'cost'     => 55,
            'points'   => 110,
            'priv'     => ''
        ]);
        Package::create([
            'type'     => 2,
            'period'   => 12,
            'cost'     => 100,
            'points'   => 115,
            'priv'     => ''
        ]);
        Package::create([
            'type'     => 3,
            'period'   => 6,
            'cost'     => 70,
            'points'   => 210,
            'priv'     => ''
        ]);
        Package::create([
            'type'     => 3,
            'period'   => 12,
            'cost'     => 120,
            'points'   => 215,
            'priv'     => ''
        ]);
        Package::create([
            'type'     => 4,
            'period'   => 12,
            'cost'     => 150,
            'points'   => 1000,
            'priv'     => ''
        ]);

    }
}