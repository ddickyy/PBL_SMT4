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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('id_reservasi');

            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_jadwal')->constrained('jadwal_dokter', 'id_jadwal')->cascadeOnDelete();

            $table->date('tanggal_reservasi');
            $table->string('nomor_antrian', 50);
            $table->time('estimasi_jam')->nullable();

            $table->enum('status', [
                'menunggu',
                'dikonfirmasi',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_jadwal', 'tanggal_reservasi', 'nomor_antrian']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
