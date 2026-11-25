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
        Schema::create('jadwal_dosen', function (Blueprint $table) {
            // Primary key custom
            $table->id('id_jadwal'); 

            // Relasi dosen (sesuaikan 'users' jadi 'profil_dosen' jika FK-nya ke sana)
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('metode', ['online', 'offline']);
            $table->string('lokasi_atau_link');
            $table->enum('status_slot', ['tersedia', 'penuh', 'selesai'])->default('tersedia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_dosens');
    }
};
