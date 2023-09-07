<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Test User SPV',
            'npk' => '2020', // NPK Anda
            'posisi' => 'SPV', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('12345678'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Test User Manajer',
            'npk' => '2021', // NPK Anda
            'posisi' => 'Manajer', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('12345678'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Test User LDR',
            'npk' => '2022', // NPK Anda
            'posisi' => 'LDR', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('12345678'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Test User JP',
            'npk' => '2023', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('12345678'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
    }
}
