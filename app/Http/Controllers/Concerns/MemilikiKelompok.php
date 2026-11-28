<?php

namespace App\Http\Controllers\Concerns;

use App\Models\AnggotaKelompok;
use App\Models\Kelompok;
use Illuminate\Support\Facades\Auth;

trait MemilikiKelompok
{
    // Kelompok tempat user yang sedang login sudah diterima sebagai anggota
    protected function kelompokSaya(): ?Kelompok
    {
        $keanggotaan = AnggotaKelompok::with('kelompok')
            ->where('user_id', Auth::id())
            ->where('status_bergabung', 'diterima')
            ->first();

        return $keanggotaan?->kelompok;
    }

    protected function pastikanMahasiswa(): void
    {
        abort_unless(Auth::user()->role === 'mahasiswa', 403, 'Hanya mahasiswa yang bisa mengakses fitur ini.');
    }
}
