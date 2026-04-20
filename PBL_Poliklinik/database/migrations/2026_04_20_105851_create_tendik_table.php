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
        Schema::create('tendik', function (Blueprint $table) {
            $table->id('id_tendik');
            $table->foreignId('id_user')->unique()->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_jabatan')->constrained('jabatan_tendik', 'id_jabatan');

            $table->string('nip')->unique();
            $table->string('no_hp')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tendik');
    }
};
