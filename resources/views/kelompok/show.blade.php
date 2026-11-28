@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    @if (session('sukses'))
        <div class="rounded-lg bg-green-100 px-4 py-2 text-green-800">{{ session('sukses') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-lg bg-red-100 px-4 py-2 text-red-800">{{ session('error') }}</div>
    @endif

    <a href="{{ route('match.index') }}" class="text-sm text-gray-500">&larr; Kembali ke PKM Match</a>

    <div class="rounded-xl border bg-white p-6">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold">{{ $kelompok->nama_kelompok }}</h1>
                <p class="text-sm text-gray-500">
                    Ketua: {{ $kelompok->ketua->name }}
                    &middot; Dosen pembimbing: {{ $kelompok->dosenPembimbing->name ?? 'Belum ada' }}
                </p>
            </div>
            <span class="rounded bg-orange-100 px-2 py-0.5 text-sm text-orange-700">{{ $kelompok->skema_pkm }}</span>
        </div>
        <p class="mt-1 text-xs text-gray-500">{{ $namaSkema }}</p>

        <p class="mt-4 text-gray-700">{{ $kelompok->deskripsi_kebutuhan ?: 'Belum ada deskripsi kebutuhan.' }}</p>

        <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
            <span>Rekrutmen: <strong>{{ ucfirst($kelompok->status_rekrutmen) }}</strong></span>
            <span>Anggota: <strong>{{ $diterima->count() }}/{{ $maks }}</strong></span>
        </div>

        @if ($diterima->count() < 3)
            <p class="mt-3 rounded-lg bg-yellow-50 px-3 py-2 text-sm text-yellow-800">
                Tim PKM terdiri dari 3-5 mahasiswa. Saat ini baru {{ $diterima->count() }} anggota.
            </p>
        @endif

        <div class="mt-4 flex flex-wrap gap-3">
            @if (auth()->user()->role === 'mahasiswa'
                && ! $kelompokSaya
                && (! $keanggotaanSaya || $keanggotaanSaya->status_bergabung === 'ditolak')
                && $kelompok->status_rekrutmen === 'terbuka')
                <form method="POST" action="{{ route('kelompok.gabung', $kelompok) }}">
                    @csrf
                    <button type="submit" class="rounded-lg bg-orange-600 px-4 py-2 text-white">Ajukan gabung</button>
                </form>
            @endif

            @if ($keanggotaanSaya && $keanggotaanSaya->status_bergabung === 'pending')
                <span class="rounded-lg bg-yellow-100 px-4 py-2 text-yellow-800">Menunggu persetujuan ketua</span>
            @endif

            @if ($keanggotaanSaya && $keanggotaanSaya->status_bergabung === 'diterima')
                <a href="{{ route('todo.index') }}" class="rounded-lg bg-green-700 px-4 py-2 text-white">Buka To-Do List</a>
            @endif
        </div>
    </div>

    <div class="rounded-xl border bg-white p-6">
        <h2 class="mb-3 text-lg font-semibold">Anggota</h2>
        <ul class="divide-y">
            @foreach ($diterima as $a)
                <li class="flex flex-wrap items-center justify-between gap-3 py-3">
                    <div>
                        <p class="font-medium">{{ $a->user->name }}</p>
                        <p class="text-xs text-gray-500">Peran: {{ $a->peran_anggota }}</p>
                    </div>

                    @if ($isKetua && $a->user_id !== $kelompok->ketua_id)
                        <form method="POST" action="{{ route('kelompok.anggota.peran', [$kelompok, $a]) }}" class="flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="peran_anggota" class="rounded-lg border px-2 py-1 text-sm">
                                @foreach (['anggota', 'penulis', 'analis data', 'programmer', 'desainer', 'bendahara'] as $peran)
                                    <option value="{{ $peran }}" @selected($a->peran_anggota === $peran)>{{ ucfirst($peran) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="rounded-lg bg-gray-800 px-3 py-1 text-sm text-white">Simpan</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    @if ($isKetua)
        <div class="rounded-xl border bg-white p-6">
            <h2 class="mb-3 text-lg font-semibold">Permintaan bergabung</h2>
            @forelse ($pending as $req)
                <div class="flex items-center justify-between gap-3 border-b py-3 last:border-0">
                    <p>{{ $req->user->name }}</p>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('kelompok.anggota.status', [$kelompok, $req]) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_bergabung" value="diterima">
                            <button type="submit" class="rounded-lg bg-green-700 px-3 py-1 text-sm text-white">Terima</button>
                        </form>
                        <form method="POST" action="{{ route('kelompok.anggota.status', [$kelompok, $req]) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_bergabung" value="ditolak">
                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-1 text-sm text-white">Tolak</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada permintaan masuk.</p>
            @endforelse
        </div>
    @endif
</div>
@endsection
