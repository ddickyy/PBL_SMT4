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
        Schema::create('kuota_harian', function (Blueprint $table) {
            $table->id('id_kuota');
            $table->foreignId('id_jadwal')->constrained('jadwal_dokter', 'id_jadwal')->cascadeOnDelete();

            $table->date('tanggal');
            $table->integer('kuota_terisi')->default(0);
            $table->integer('kuota_maksimal');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_jadwal', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuota_harian');
    }
};
