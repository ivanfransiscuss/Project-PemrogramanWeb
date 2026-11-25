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
        Schema::create('booking_bimbingan', function (Blueprint $table) {
            // Primary key custom
            $table->id('id_bimbingan');
            // Relasi ke jadwal_dosen (pakai id_jadwal)
            $table->foreignId('jadwal_id')->constrained('jadwal_dosen', 'id_jadwal')->onDelete('cascade');
            // Relasi ke kelompok
            $table->foreignId('kelompok_id')->constrained('kelompoks')->onDelete('cascade');
            $table->text('topik_bimbingan');
            $table->enum('status_booking', ['menunggu', 'disetujui', 'ditolak', 'batal'])->default('menunggu');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_bimbingans');
    }
};
