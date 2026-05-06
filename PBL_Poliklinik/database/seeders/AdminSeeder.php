<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            [
                'id_user' => '1',
                'tipe_admin' => 'Super Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('admin')->insert($admin);
    }
}
