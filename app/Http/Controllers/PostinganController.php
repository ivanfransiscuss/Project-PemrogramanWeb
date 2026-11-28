<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\MemilikiKelompok;
use App\Models\BalasanPostingan;
use App\Models\Postingan;
use App\Support\PkmData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostinganController extends Controller
{
    use MemilikiKelompok;

    // Feed PKM Match: postingan terbaru + filter jenis, skema, dan pencarian
    public function index(Request $request)
    {
        $postingan = Postingan::with(['user', 'kelompok'])
            ->withCount('balasan')
            ->when($request->filled('tipe'), fn ($q) => $q->where('tipe', $request->tipe))
            ->when($request->filled('skema'), fn ($q) => $q->where('skema_pkm', $request->skema))
            ->when($request->filled('q'), fn ($q) => $q->where('isi', 'like', '%' . $request->q . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('match.index', [
            'postingan' => $postingan,
            'kelompokSaya' => $this->kelompokSaya(),
            'tipeBoleh' => $this->tipeYangBoleh(),
            'daftarSkema' => PkmData::SKEMA,
            'daftarTipe' => PkmData::TIPE_POSTINGAN,
        ]);
    }

    public function store(Request $request)
    {
        $this->pastikanMahasiswa();

        $data = $request->validate([
            'tipe' => ['required', Rule::in($this->tipeYangBoleh())],
            'skema_pkm' => ['nullable', Rule::in(PkmData::kodeSkema())],
            'isi' => 'required|string|max:1000',
        ]);

        $kelompok = $this->kelompokSaya();

        Postingan::create([
            'user_id' => Auth::id(),
            'kelompok_id' => $data['tipe'] === 'cari_anggota' ? $kelompok?->id : null,
            'tipe' => $data['tipe'],
            'skema_pkm' => $data['skema_pkm'] ?? null,
            'isi' => $data['isi'],
            'status' => 'aktif',
        ]);

        return redirect()->route('match.index')->with('sukses', 'Postingan terkirim.');
    }

    // Jenis postingan yang boleh dibuat user yang sedang login
    private function tipeYangBoleh(): array
    {
        $kelompok = $this->kelompokSaya();

        if (! $kelompok) {
            return ['cari_kelompok', 'lainnya'];
        }

        if ($kelompok->ketua_id === Auth::id() && $kelompok->status_rekrutmen === 'terbuka') {
            return ['cari_anggota', 'lainnya'];
        }

        return ['lainnya'];
    }
}

