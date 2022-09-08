<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Bimal',
            'email' => 'bimal@bimal.com',
            'phone_number' => '1111111111',
            'password' => Hash::make('00000000'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('users')->insert([
            'name' => 'Jayesh',
            'email' => 'jayesh@jayesh.com',
            'phone_number' => '2222222222',
            'password' => Hash::make('00000000'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('users')->insert([
            'name' => 'distributorA',
            'email' => 'distributor@distributor.com',
            'phone_number' => '33333333333',
            'password' => Hash::make('00000000'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
