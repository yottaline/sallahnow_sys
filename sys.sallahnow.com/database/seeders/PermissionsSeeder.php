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
        $user = new User_group();
        $user->user_group_name = 'Admin';
        $user->user_group_privileges = '[add-users,view-users,update-users]';
        $user->save();
        // User_group::create([
        //     'user_group_name' => 'Admin',
        //     'user_group_privileges'  => '[add-users,view-users,update-users]',
        // ]);

        Package::create([
            'pkg_type'     => 1,
            'pkg_period'   => 0,
            'pkg_cost'     => 0,
            'pkg_points'   => 0,
            'pkg_priv'     => ''
        ]);
        Package::create([
            'pkg_type'     => 2,
            'pkg_period'   => 1,
            'pkg_cost'     => 10,
            'pkg_points'   => 100,
            'pkg_priv'     => ''
        ]);
        Package::create([
            'pkg_type'     => 2,
            'pkg_period'   => 6,
            'pkg_cost'     => 55,
            'pkg_points'   => 110,
            'pkg_priv'     => ''
        ]);
        Package::create([
            'pkg_type'     => 2,
            'pkg_period'   => 12,
            'pkg_cost'     => 100,
            'pkg_points'   => 115,
            'pkg_priv'     => ''
        ]);
        Package::create([
            'pkg_type'     => 3,
            'pkg_period'   => 6,
            'pkg_cost'     => 70,
            'pkg_points'   => 210,
            'pkg_priv'     => ''
        ]);
        Package::create([
            'pkg_type'     => 3,
            'pkg_period'   => 12,
            'pkg_cost'     => 120,
            'pkg_points'   => 215,
            'pkg_priv'     => ''
        ]);
        Package::create([
            'pkg_type'     => 4,
            'pkg_period'   => 12,
            'pkg_cost'     => 150,
            'pkg_points'   => 1000,
            'pkg_priv'     => ''
        ]);

    }
}