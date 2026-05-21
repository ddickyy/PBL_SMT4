<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_status_reservasi', function (Blueprint $table) {
            $table->id('id_riwayat');

            $table->foreignId('id_reservasi')->constrained('reservasi', 'id_reservasi')->cascadeOnDelete();
            $table->foreignId('diubah_oleh')->nullable()->constrained('users', 'id_user')->nullOnDelete();

            $table->enum('status_baru', [
                'menunggu',
                'dikonfirmasi',
                'selesai',
                'dibatalkan'
            ]);

            $table->text('keterangan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_reservasi');
    }
};
