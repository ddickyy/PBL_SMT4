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
        Schema::create('prodi', function (Blueprint $table) {
            $table->id('id_prodi');
            $table->foreignId('id_jurusan')->constrained('jurusan', 'id_jurusan')->cascadeOnDelete();

            $table->string('nama_prodi');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_jurusan', 'nama_prodi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
