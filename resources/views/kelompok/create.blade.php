@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl space-y-4">
    <h1 class="text-2xl font-bold">Buat Kelompok PKM</h1>

    <form method="POST" action="{{ route('kelompok.store') }}" class="space-y-4 rounded-xl border bg-white p-6">
        @csrf

        <div>
            <label class="block text-sm font-medium">Nama kelompok</label>
            <input type="text" name="nama_kelompok" value="{{ old('nama_kelompok') }}"
                   class="mt-1 w-full rounded-lg border px-3 py-2">
            @error('nama_kelompok') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Skema PKM</label>
            <select name="skema_pkm" class="mt-1 w-full rounded-lg border px-3 py-2">
                <option value="">Pilih skema</option>
                @foreach ($daftarSkema as $kode => $nama)
                    <option value="{{ $kode }}" @selected(old('skema_pkm') === $kode)>{{ $kode }} - {{ $nama }}</option>
                @endforeach
            </select>
            @error('skema_pkm') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Keahlian / kebutuhan anggota</label>
            <textarea name="deskripsi_kebutuhan" rows="4"
                      class="mt-1 w-full rounded-lg border px-3 py-2"
                      placeholder="Contoh: butuh anggota yang paham analisis data dan penulisan proposal">{{ old('deskripsi_kebutuhan') }}</textarea>
            @error('deskripsi_kebutuhan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-orange-600 px-4 py-2 text-white">Buat kelompok</button>
            <a href="{{ route('match.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
