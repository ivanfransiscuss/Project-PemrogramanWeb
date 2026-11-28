@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl space-y-6">
    @if (session('sukses'))
        <div class="rounded-lg bg-green-100 px-4 py-2 text-green-800">{{ session('sukses') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-lg bg-red-100 px-4 py-2 text-red-800">{{ session('error') }}</div>
    @endif

    <a href="{{ route('match.index') }}" class="text-sm text-gray-500">&larr; Kembali ke PKM Match</a>

    <article class="rounded-xl border bg-white p-4">
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

        @if ($p->user_id === auth()->id())
            <div class="mt-4 flex gap-4 border-t pt-3 text-sm">
                @if ($p->status === 'aktif')
                    <form method="POST" action="{{ route('match.selesai', $p) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-green-700">Tandai selesai</button>
                    </form>
                @endif
                <form method="POST" action="{{ route('match.destroy', $p) }}"
                      onsubmit="return confirm('Hapus postingan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600">Hapus</button>
                </form>
            </div>
        @endif
    </article>

    <section class="space-y-3">
        <h2 class="font-semibold">Balasan ({{ $p->balasan->count() }})</h2>
        @forelse ($p->balasan as $b)
            <div class="rounded-xl border bg-white p-3">
                <p class="text-sm font-semibold">
                    {{ $b->user->name }}
                    <span class="text-xs font-normal text-gray-500">{{ $b->created_at->locale('id')->diffForHumans() }}</span>
                </p>
                <p class="mt-1 whitespace-pre-line text-sm text-gray-800">{{ $b->isi }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada balasan.</p>
        @endforelse
    </section>

    @if ($p->status === 'aktif')
        <form method="POST" action="{{ route('match.balas', $p) }}" class="space-y-2 rounded-xl border bg-white p-4">
            @csrf
            <textarea name="isi" rows="2" maxlength="500" placeholder="Tulis balasan..."
                      class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('isi') }}</textarea>
            @error('isi') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            <button type="submit" class="rounded-lg bg-orange-600 px-4 py-2 text-sm text-white">Balas</button>
        </form>
    @endif
</div>
@endsection
