<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = Role::where(
            'nama_role',
            'superadmin'
        )->first();

        $admin = Role::where(
            'nama_role',
            'admin'
        )->first();

        $dokter = Role::where(
            'nama_role',
            'dokter'
        )->first();

        $pasien = Role::where(
            'nama_role',
            'pasien'
        )->first();

        $superadmin?->permissions()->sync(
            Permission::pluck(
                'id_permission'
            )
        );

        $adminPermissions = Permission::whereIn(
            'nama_permission',
            [
                'dokter',
                'jadwal_dokter',
                'rekam_medis',
                'riwayat_reservasi',
                'reservasi',
                'penilaian',
            ]
        )
        ->pluck('id_permission');

        $admin?->permissions()
            ->sync($adminPermissions);

        $dokterPermissions = Permission::whereIn(
            'nama_permission',
            [
                'jadwal_dokter',
                'rekam_medis',
                'riwayat_reservasi',
                'reservasi',
                'penilaian',
            ]
        )
        ->pluck('id_permission');

        $dokter?->permissions()
            ->sync($dokterPermissions);

        $pasien?->permissions()
            ->sync([]);
    }
}