<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kelompok_id')->nullable()->constrained('kelompok')->nullOnDelete();
            $table->enum('tipe', ['cari_kelompok', 'cari_anggota', 'lainnya'])->default('lainnya');
            $table->string('skema_pkm', 20)->nullable();
            $table->text('isi');
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postingan');
    }
};
