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

    // Mahasiswa mengajukan diri bergabung
    public function gabung(Kelompok $kelompok)
    {
        $this->pastikanMahasiswa();

        if ($this->kelompokSaya()) {
            return back()->with('error', 'Kamu sudah tergabung di sebuah kelompok.');
        }

        if ($kelompok->status_rekrutmen !== 'terbuka') {
            return back()->with('error', 'Kelompok ini tidak sedang membuka rekrutmen.');
        }

        $jumlah = $kelompok->anggota()->where('status_bergabung', 'diterima')->count();
        if ($jumlah >= self::MAKS_ANGGOTA) {
            return back()->with('error', 'Kelompok sudah penuh.');
        }

        $sudahMengajukan = AnggotaKelompok::where('kelompok_id', $kelompok->id)
            ->where('user_id', Auth::id())
            ->where('status_bergabung', 'pending')
            ->exists();

        if ($sudahMengajukan) {
            return back()->with('error', 'Permintaan kamu masih menunggu persetujuan ketua.');
        }

        AnggotaKelompok::updateOrCreate(
            ['kelompok_id' => $kelompok->id, 'user_id' => Auth::id()],
            ['peran_anggota' => 'anggota', 'status_bergabung' => 'pending']
        );

        return back()->with('sukses', 'Permintaan bergabung terkirim. Tunggu persetujuan ketua.');
    }

    // Ketua menerima atau menolak permintaan gabung
    public function updateStatus(Request $request, Kelompok $kelompok, AnggotaKelompok $anggota)
    {
        abort_unless($kelompok->ketua_id === Auth::id(), 403);
        abort_unless($anggota->kelompok_id === $kelompok->id, 404);

        $data = $request->validate([
            'status_bergabung' => ['required', Rule::in(['diterima', 'ditolak'])],
        ]);

        if ($data['status_bergabung'] === 'diterima') {
            $sudahDiKelompokLain = AnggotaKelompok::where('user_id', $anggota->user_id)
                ->where('status_bergabung', 'diterima')
                ->where('kelompok_id', '!=', $kelompok->id)
                ->exists();

            if ($sudahDiKelompokLain) {
                return back()->with('error', 'Mahasiswa ini sudah bergabung di kelompok lain.');
            }

            $jumlah = $kelompok->anggota()->where('status_bergabung', 'diterima')->count();
            if ($jumlah >= self::MAKS_ANGGOTA) {
                return back()->with('error', 'Kelompok sudah penuh.');
            }
        }

        $anggota->update(['status_bergabung' => $data['status_bergabung']]);

        // Kalau sudah penuh: tutup rekrutmen dan selesaikan postingan "kekurangan anggota"
        $jumlahBaru = $kelompok->anggota()->where('status_bergabung', 'diterima')->count();
        if ($jumlahBaru >= self::MAKS_ANGGOTA) {
            $kelompok->update(['status_rekrutmen' => 'penuh']);
            Postingan::where('kelompok_id', $kelompok->id)
                ->where('status', 'aktif')
                ->update(['status' => 'selesai']);
        }

        return back()->with('sukses', 'Status anggota diperbarui.');
    }

    // Ketua mengatur peran anggota
    public function updatePeran(Request $request, Kelompok $kelompok, AnggotaKelompok $anggota)
    {
        abort_unless($kelompok->ketua_id === Auth::id(), 403);
        abort_unless($anggota->kelompok_id === $kelompok->id, 404);

        if ($anggota->user_id === $kelompok->ketua_id) {
            return back()->with('error', 'Peran ketua tidak bisa diubah.');
        }

        $data = $request->validate([
            'peran_anggota' => 'required|string|max:50',
        ]);

        $anggota->update($data);

        return back()->with('sukses', 'Peran anggota diperbarui.');
    }
}

