@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl space-y-6">
    @if (session('sukses'))
        <div class="rounded-lg bg-green-100 px-4 py-2 text-green-800">{{ session('sukses') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-lg bg-red-100 px-4 py-2 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">PKM Match</h1>
            <p class="text-sm text-gray-500">Cari rekan satu tim atau umumkan kebutuhan kelompokmu.</p>
        </div>
        @if ($kelompokSaya)
            <a href="{{ route('kelompok.show', $kelompokSaya) }}"
               class="rounded-lg bg-green-700 px-4 py-2 text-sm text-white">Kelompok Saya</a>
        @elseif (auth()->user()->role === 'mahasiswa')
            <a href="{{ route('kelompok.create') }}"
               class="rounded-lg bg-orange-600 px-4 py-2 text-sm text-white">+ Buat Kelompok</a>
        @endif
    </div>

    @if (auth()->user()->role === 'mahasiswa')
        <form method="POST" action="{{ route('match.store') }}" class="space-y-3 rounded-xl border bg-white p-4">
            @csrf
            <textarea name="isi" rows="3" maxlength="1000"
                      placeholder="Tulis sesuatu, misalnya: butuh anggota yang paham analisis data untuk PKM-RE"
                      class="w-full rounded-lg border px-3 py-2">{{ old('isi') }}</textarea>
            @error('isi') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

            <div class="flex flex-wrap items-center gap-3">
                <select name="tipe" class="rounded-lg border px-3 py-2 text-sm">
                    @foreach ($tipeBoleh as $t)
                        <option value="{{ $t }}" @selected(old('tipe') === $t)>{{ $daftarTipe[$t] }}</option>
                    @endforeach
                </select>
                <select name="skema_pkm" class="rounded-lg border px-3 py-2 text-sm">
                    <option value="">Skema (opsional)</option>
                    @foreach ($daftarSkema as $kode => $nama)
                        <option value="{{ $kode }}" @selected(old('skema_pkm') === $kode)>{{ $kode }} - {{ $nama }}</option>
                    @endforeach
                </select>
                <button type="submit" class="ml-auto rounded-lg bg-orange-600 px-4 py-2 text-sm text-white">Posting</button>
            </div>
            @error('tipe') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            @error('skema_pkm') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </form>
    @endif

    <form method="GET" action="{{ route('match.index') }}" class="flex flex-wrap gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kata kunci..."
               class="min-w-40 flex-1 rounded-lg border px-3 py-2 text-sm">
        <select name="tipe" class="rounded-lg border px-3 py-2 text-sm">
            <option value="">Semua jenis</option>
            @foreach ($daftarTipe as $kode => $nama)
                <option value="{{ $kode }}" @selected(request('tipe') === $kode)>{{ $nama }}</option>
            @endforeach
        </select>
        <select name="skema" class="rounded-lg border px-3 py-2 text-sm">
            <option value="">Semua skema</option>
            @foreach ($daftarSkema as $kode => $nama)
                <option value="{{ $kode }}" @selected(request('skema') === $kode)>{{ $kode }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2 text-sm text-white">Cari</button>
    </form>

    @forelse ($postingan as $p)
        <article class="rounded-xl border bg-white p-4 {{ $p->status === 'selesai' ? 'opacity-60' : '' }}">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-sm font-semibold">
                        {{ strtoupper(substr($p->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ $p->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $p->created_at->locale('id')->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap justify-end gap-1">
                    <span class="rounded bg-orange-100 px-2 py-0.5 text-xs text-orange-700">{{ $daftarTipe[$p->tipe] }}</span>
                    @if ($p->skema_pkm)
                        <span class="rounded bg-blue-100 px-2 py-0.5 text-xs text-blue-700">{{ $p->skema_pkm }}</span>
                    @endif
                    @if ($p->status === 'selesai')
                        <span class="rounded bg-gray-200 px-2 py-0.5 text-xs text-gray-700">Selesai</span>
                    @endif
                </div>
            </div>

            <p class="mt-3 whitespace-pre-line text-gray-800">{{ $p->isi }}</p>

            @if ($p->kelompok)
                <a href="{{ route('kelompok.show', $p->kelompok) }}"
                   class="mt-3 block rounded-lg border bg-gray-50 px-3 py-2 text-sm">
                    <span class="font-medium">{{ $p->kelompok->nama_kelompok }}</span>
                    <span class="text-gray-500">&middot; {{ $p->kelompok->skema_pkm }}</span>
                </a>
            @endif

            <div class="mt-3 text-sm">
                <a href="{{ route('match.show', $p) }}" class="text-green-700">Balasan ({{ $p->balasan_count }})</a>
            </div>
        </article>
    @empty
        <p class="text-center text-gray-500">Belum ada postingan. Jadi yang pertama!</p>
    @endforelse

    {{ $postingan->links() }}
</div>
@endsection
