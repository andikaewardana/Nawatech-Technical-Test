<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = [
            ['name'=> Str::random(10),'email'=>'testing@gmail.com', 'password' => Hash::make('password'), 'role'=>'0'],
            ['name'=> Str::random(10),'email'=>'test@gmail.com', 'password' => Hash::make('password'), 'role'=>'1']
        ];

        DB::table('user')->insert($user);
    }
}
