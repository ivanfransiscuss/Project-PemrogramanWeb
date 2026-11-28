<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id')->constrained('kelompok')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->date('tanggal_bimbingan');
            $table->string('topik_pembahasan', 200);
            $table->text('catatan_mahasiswa');
            $table->text('catatan_revisi_dosen')->nullable();
            $table->string('file_revisi')->nullable();
            $table->enum('status', ['menunggu_review', 'revisi', 'disetujui'])->default('menunggu_review');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};