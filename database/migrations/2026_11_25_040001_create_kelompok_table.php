<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok', 100);
            $table->string('skema_pkm', 20);
            $table->text('deskripsi_kebutuhan')->nullable();
            $table->foreignId('ketua_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('dosen_pembimbing_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status_rekrutmen', ['terbuka', 'penuh', 'ditutup'])->default('terbuka');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok');
    }
};