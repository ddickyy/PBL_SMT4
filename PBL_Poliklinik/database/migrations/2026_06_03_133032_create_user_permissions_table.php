<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_permissions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('id_user')
                ->constrained(
                    'users',
                    'id_user'
                )
                ->cascadeOnDelete();

            $table->foreignId('id_permission')
                ->constrained(
                    'permissions',
                    'id_permission'
                )
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'id_user',
                'id_permission'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'user_permissions'
        );
    }
};