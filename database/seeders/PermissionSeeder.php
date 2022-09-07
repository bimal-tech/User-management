<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'see user list',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'create user',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit user',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete user',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'see role list',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'create role',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit role',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete role',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'see permission list',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'create permission',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit permission',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete permission',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'assign permission',
            'guard_name' => 'web',
        ]);
        DB::table('permissions')->insert([
            'name' => 'revoke permission',
            'guard_name' => 'web',
        ]);  
        
        $permissions=[1,2,3,4,5,6,7,8,9,10,11,12,13,14];
        
        $user1=User::find(1);
        $user1->givePermissionTo($permissions);
        $user2=User::find(2);
        $user2->givePermissionTo($permissions);
        $user3=User::find(3);
        $user3->givePermissionTo($permissions);
    }
}
