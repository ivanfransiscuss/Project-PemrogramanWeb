<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repositori_pkm', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->enum('kategori', ['template', 'contoh_proposal']);
            $table->string('skema_pkm', 30);
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repositori_pkm');
    }
};