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
        Schema::table('reservasi', function (Blueprint $table) {
            $table->boolean('viewed')->default(false)->after('status');
        });

        Schema::table('penilaian', function (Blueprint $table) {
            $table->boolean('viewed')->default(false)->after('saran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            $table->dropColumn('viewed');
        });

        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropColumn('viewed');
        });
    }
};
