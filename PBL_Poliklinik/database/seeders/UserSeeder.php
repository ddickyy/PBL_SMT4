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
            ]
        ];

        DB::table('users')->insert($user);
    }
}
