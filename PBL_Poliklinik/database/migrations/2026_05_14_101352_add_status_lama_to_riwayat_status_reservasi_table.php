<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_status_reservasi', function (Blueprint $table) {

            $table->enum('status_lama', [
                'menunggu',
                'dikonfirmasi',
                'selesai',
                'dibatalkan'
            ])
            ->after('diubah_oleh')
            ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('riwayat_status_reservasi', function (Blueprint $table) {

            $table->dropColumn('status_lama');

        });
    }
};