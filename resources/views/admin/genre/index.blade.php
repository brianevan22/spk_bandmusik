{{-- FILE: resources/views/admin/genre/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Manajemen Genre')
@section('sidebar-subtitle', 'Panel Administrator')

@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">ADMIN MENU</div>
<a href="{{ route('admin.dashboard') }}" class="nav-link">📊 Dashboard Admin</a>
<a href="{{ route('admin.band.index') }}" class="nav-link">🎵 Manajemen Band</a>
<a href="{{ route('admin.anggota.index') }}" class="nav-link">👥 Manajemen Anggota</a>
<a href="{{ route('admin.genre.index') }}" class="nav-link active">🎼 Manajemen Genre</a>
<a href="{{ route('admin.log.index') }}" class="nav-link">📋 Log Aktivitas</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-white mb-1">Manajemen Genre Musik</h1>
<p class="text-gray-400 text-sm mb-5">Kelola daftar genre yang tersedia sebagai opsi filter pencarian band.</p>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Daftar Genre --}}
    <div class="lg:col-span-2 card p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <h2 class="font-bold text-white">Daftar Genre</h2>
                <span class="badge text-xs" style="background:#1a2a1a;color:#4ade80">{{ $genres->count() }} genre</span>
            </div>
            <a href="{{ route('admin.genre.create') }}"
               class="px-4 py-2 rounded-lg text-xs font-bold text-black"
               style="background:#F5A623;text-decoration:none">+ Tambah Genre</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-500 text-xs" style="border-bottom:1px solid #333">
                        <th class="text-left py-2 pr-4">#ID</th>
                        <th class="text-left py-2 pr-4">NAMA GENRE</th>
                        <th class="text-left py-2 pr-4">JUMLAH BAND</th>
                        <th class="text-left py-2 pr-4">STATUS</th>
                        <th class="text-left py-2">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($genres as $genre)
                    <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                        <td class="py-3 pr-4 text-gray-500 text-xs">G{{ str_pad($genre->id, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-3 pr-4 font-semibold text-white">{{ $genre->nama_genre }}</td>
                        <td class="py-3 pr-4 text-gray-300">{{ $genre->bands_count }}</td>
                        <td class="py-3 pr-4">
                            <span class="badge" style="background:{{ $genre->status=='aktif'?'#052e16':'#450a0a' }};color:{{ $genre->status=='aktif'?'#4ade80':'#f87171' }}">
                                {{ $genre->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="py-3 flex gap-2">
                            <a href="{{ route('admin.genre.edit', $genre) }}"
                               class="w-8 h-8 rounded flex items-center justify-center text-sm"
                               style="background:#222;border:1px solid #333;text-decoration:none">✏️</a>
                            <form method="POST" action="{{ route('admin.genre.destroy', $genre) }}"
                                  onsubmit="return confirm('Hapus genre {{ $genre->nama_genre }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded text-sm"
                                    style="background:#450a0a;border:1px solid #991b1b">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Distribusi Genre --}}
    <div class="card p-5">
        <h2 class="font-bold text-white mb-4">Distribusi Genre</h2>
        @foreach($genres->sortByDesc('bands_count')->take(6) as $genre)
        @php $maxBand = $genres->max('bands_count') ?: 1; @endphp
        <div class="mb-3">
            <div class="flex justify-between text-sm mb-1">
                <span class="text-white">{{ $genre->nama_genre }}</span>
                <span class="text-gray-400">{{ $genre->bands_count }} band</span>
            </div>
            <div class="rounded-full" style="background:#222;height:6px">
                <div class="rounded-full" style="background:#F5A623;height:6px;width:{{ ($genre->bands_count/$maxBand)*100 }}%"></div>
            </div>
        </div>
        @endforeach

        <div class="mt-5 p-3 rounded-lg text-sm" style="background:#2a1a00;color:#fbbf24;border:1px solid #92400e">
            ⚠️ <strong>Catatan Hapus Genre</strong><br>
            <span class="text-xs">Genre yang masih digunakan oleh satu atau lebih band <strong>tidak dapat dihapus</strong> secara langsung.</span>
        </div>
    </div>
</div>
@endsection
