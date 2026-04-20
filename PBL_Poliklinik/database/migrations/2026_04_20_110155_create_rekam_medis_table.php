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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id('id_rekam');

            $table->foreignId('id_reservasi')->unique()->constrained('reservasi', 'id_reservasi')->cascadeOnDelete();
            $table->foreignId('id_dokter')->constrained('dokter', 'id_dokter')->cascadeOnDelete();

            $table->text('diagnosis');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_periksa');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
