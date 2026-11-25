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
        Schema::create('pengajuan_dospem', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->foreignId('kelompok_id')
                ->constrained('kelompok')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('dosen_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('judul_proposal', 255);
            $table->text('abstract_singkat');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();

            // supaya satu kelompok tidak mengajukan ke dospem yang sama berulang kali
            $table->unique(['kelompok_id', 'dosen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_dospem');
    }
};
