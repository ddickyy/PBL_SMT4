<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'id_role' => '1',
                'nama' => 'Super Admin 1',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id_role' => '2',
                'nama' => 'Admin Poliklinik 1',
                'email' => 'adminpoli@gmail.com',
                'password' => bcrypt('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id_role' => '4',
                'nama' => 'Esatovin Victoria',
                'email' => 'esatovin@gmail.com',
                'password' => bcrypt('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id_role' => '4',
                'nama' => 'Dicky Darmawan',
                'email' => 'dicky@gmail.com',
                'password' => bcrypt('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id_role' => '4',
                'nama' => 'Sheilandra Zarawiba',
                'email' => 'sheilandra@gmail.com',
                'password' => bcrypt('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id_role' => '4',
                'nama' => 'Raymon Devtant',
                'email' => 'raymon@gmail.com',
                'password' => bcrypt('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($user);
    }
}
