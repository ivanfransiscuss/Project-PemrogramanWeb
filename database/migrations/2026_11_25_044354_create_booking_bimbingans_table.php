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
            $table->id('id_bimbingan');
            $table->foreignId('jadwal_id')->constrained('jadwal_dosen', 'id_jadwal')->onDelete('cascade');
            $table->foreignId('kelompok_id')->constrained('kelompok')->onDelete('cascade');
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
        Schema::dropIfExists('booking_bimbingan');
    }
};