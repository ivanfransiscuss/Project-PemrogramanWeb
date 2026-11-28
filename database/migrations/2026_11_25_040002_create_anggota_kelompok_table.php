<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_kelompok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id')->constrained('kelompok')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('peran_anggota', 50)->default('anggota');
            $table->enum('status_bergabung', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();

            $table->unique(['kelompok_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_kelompok');
    }
};