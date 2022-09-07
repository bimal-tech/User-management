<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'superadmin',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'distributor',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'creator',
            'guard_name' => 'web',
        ]);
        DB::table('roles')->insert([
            'name' => 'editor',
            'guard_name' => 'web',
        ]);

        $user1=User::find(1);
        $user1->assignRole(1);
        $user2=User::find(2);
        $user2->assignRole(2);
        $user3=User::find(3);
        $user3->assignRole(3);
    }


}
