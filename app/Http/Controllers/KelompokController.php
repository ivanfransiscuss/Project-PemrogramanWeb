<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\MemilikiKelompok;
use App\Models\AnggotaKelompok;
use App\Models\Kelompok;
use App\Models\Postingan;
use App\Models\Todo;
use App\Support\PkmData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KelompokController extends Controller
{
    use MemilikiKelompok;

    // Checklist PKM menyebut tim 3-5 mahasiswa, jadi batas maksimal 5
    private const MAKS_ANGGOTA = 5;

    public function create()
    {
        $this->pastikanMahasiswa();

        if ($sudah = $this->kelompokSaya()) {
            return redirect()->route('kelompok.show', $sudah)
                ->with('error', 'Kamu sudah tergabung di sebuah kelompok.');
        }

        return view('kelompok.create', ['daftarSkema' => PkmData::SKEMA]);
    }

    public function store(Request $request)
    {
        $this->pastikanMahasiswa();

        if ($sudah = $this->kelompokSaya()) {
            return redirect()->route('kelompok.show', $sudah)
                ->with('error', 'Kamu sudah tergabung di sebuah kelompok.');
        }

        $data = $request->validate([
            'nama_kelompok' => 'required|string|max:100',
            'skema_pkm' => ['required', Rule::in(PkmData::kodeSkema())],
            'deskripsi_kebutuhan' => 'nullable|string|max:1000',
        ]);

        $kelompok = DB::transaction(function () use ($data) {
            $kelompok = Kelompok::create([
                'nama_kelompok' => $data['nama_kelompok'],
                'skema_pkm' => $data['skema_pkm'],
                'deskripsi_kebutuhan' => $data['deskripsi_kebutuhan'] ?? null,
                'ketua_id' => Auth::id(),
                'status_rekrutmen' => 'terbuka',
            ]);

            AnggotaKelompok::create([
                'kelompok_id' => $kelompok->id,
                'user_id' => Auth::id(),
                'peran_anggota' => 'ketua',
                'status_bergabung' => 'diterima',
            ]);

            // Checklist umum kelengkapan proposal, otomatis untuk kelompok baru
            foreach (PkmData::CHECKLIST as $kategori => $daftar) {
                foreach ($daftar as $judul) {
                    Todo::create([
                        'kelompok_id' => $kelompok->id,
                        'kategori' => $kategori,
                        'judul_tugas' => $judul,
                        'is_selesai' => false,
                        'tenggat_waktu' => null,
                    ]);
                }
            }

            return $kelompok;
        });

        return redirect()->route('kelompok.show', $kelompok)
            ->with('sukses', 'Kelompok berhasil dibuat.');
    }

    public function show(Kelompok $kelompok)
    {
        $kelompok->load(['ketua', 'dosenPembimbing', 'anggota.user']);

        return view('kelompok.show', [
            'kelompok' => $kelompok,
            'diterima' => $kelompok->anggota->where('status_bergabung', 'diterima'),
            'pending' => $kelompok->anggota->where('status_bergabung', 'pending'),
            'keanggotaanSaya' => $kelompok->anggota->firstWhere('user_id', Auth::id()),
            'isKetua' => $kelompok->ketua_id === Auth::id(),
            'kelompokSaya' => $this->kelompokSaya(),
            'namaSkema' => PkmData::SKEMA[$kelompok->skema_pkm] ?? $kelompok->skema_pkm,
            'maks' => self::MAKS_ANGGOTA,
        ]);
    }
}

