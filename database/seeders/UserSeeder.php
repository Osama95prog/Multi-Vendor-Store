<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'Osama Albaida',
            'email' => 'OsamaAlbaida@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '0000000001',
        ]);
        DB::table('users')->insert([
            'name' => 'Osama Albaida',
            'email' => 'OsamaAlbaida2@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '0000000002',
        ]);
    }
}
