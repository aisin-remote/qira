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
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Sapli',
            'npk' => '000013', // NPK Anda
            'posisi' => 'Manajer', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Dani',
            'npk' => '000262', // NPK Anda
            'posisi' => 'SPV', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Faudin',
            'npk' => '002579', // NPK Anda
            'posisi' => 'LDR', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Agung Prihatin',
            'npk' => '000098', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Martinda',
            'npk' => '000241', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Imam Rifai',
            'npk' => '000323', // NPK Anda
            'posisi' => 'Sub JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'M. Ridwan',
            'npk' => '000370', // NPK Anda
            'posisi' => 'Sub JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Achmad Rifai',
            'npk' => '002128', // NPK Anda
            'posisi' => 'Sub JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'M. Ilham',
            'npk' => '002595', // NPK Anda
            'posisi' => 'LDR', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Rochaimin',
            'npk' => '000328', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Roby Purwono',
            'npk' => '000547', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Imam Mudzakir',
            'npk' => '001050', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Nasrul Gumilar',
            'npk' => '000569', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(), // Menggunakan UUID sebagai ID
            'name' => 'Subagyo',
            'npk' => '000243', // NPK Anda
            'posisi' => 'JP', // Ganti dengan posisi yang sesuai
            'password' => Hash::make('qaunit2024'), // Ganti 'password' dengan kata sandi yang Anda inginkan
        ]);
    }
}
