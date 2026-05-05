{{-- FILE: resources/views/admin/band/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Manajemen Band')
@section('sidebar-subtitle', 'Panel Administrator')

@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">ADMIN MENU</div>
<a href="{{ route('admin.dashboard') }}" class="nav-link">📊 Dashboard Admin</a>
<a href="{{ route('admin.band.index') }}" class="nav-link active">🎵 Manajemen Band</a>
<a href="{{ route('admin.anggota.index') }}" class="nav-link">👥 Manajemen Anggota</a>
<a href="{{ route('admin.genre.index') }}" class="nav-link">🎼 Manajemen Genre</a>
<a href="{{ route('admin.log.index') }}" class="nav-link">📋 Log Aktivitas</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-white mb-1">Manajemen Band Musik</h1>
<p class="text-gray-400 text-sm mb-5">Kelola data band: tambah, ubah, dan hapus informasi band.</p>

{{-- Filter & Search --}}
<form method="GET" class="flex flex-wrap gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Cari nama band..." class="input-field" style="max-width:220px">
    <select name="genre" class="input-field" style="max-width:160px">
        <option value="">Semua Genre</option>
        @foreach($genres as $g)
        <option value="{{ $g->id }}" {{ request('genre') == $g->id ? 'selected' : '' }}>{{ $g->nama_genre }}</option>
        @endforeach
    </select>
    <select name="status" class="input-field" style="max-width:160px">
        <option value="">Semua Status</option>
        <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
        <option value="nonaktif" {{ request('status')=='nonaktif'?'selected':'' }}>Nonaktif</option>
    </select>
    <button type="submit" class="btn-primary px-4 py-2 text-sm">Filter</button>
    <a href="{{ route('admin.band.create') }}" class="btn-primary px-4 py-2 text-sm" style="text-decoration:none">+ Tambah Band</a>
</form>

<div class="card p-5">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500 text-xs" style="border-bottom:1px solid #333">
                    <th class="text-left py-2 pr-4">NAMA BAND</th>
                    <th class="text-left py-2 pr-4">GENRE</th>
                    <th class="text-left py-2 pr-4">LOKASI</th>
                    <th class="text-left py-2 pr-4">BIAYA</th>
                    <th class="text-left py-2 pr-4">PENGIKUT</th>
                    <th class="text-left py-2 pr-4">TH. BERDIRI</th>
                    <th class="text-left py-2 pr-4">STATUS</th>
                    <th class="text-left py-2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bands as $band)
                <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                    <td class="py-3 pr-4 font-semibold text-white">{{ $band->nama_band }}</td>
                    <td class="py-3 pr-4">
                        <span class="badge" style="background:#1a2a4a;color:#60a5fa">{{ $band->genre->nama_genre ?? '-' }}</span>
                    </td>
                    <td class="py-3 pr-4 text-gray-300">{{ $band->lokasi }}</td>
                    <td class="py-3 pr-4 text-gray-300">Rp {{ number_format($band->biaya_sewa/1000000, 1) }} Jt</td>
                    <td class="py-3 pr-4 text-gray-300">{{ number_format($band->pengikut/1000, 0) }}K</td>
                    <td class="py-3 pr-4 text-gray-300">{{ $band->tahun_berdiri }}</td>
                    <td class="py-3 pr-4">
                        <span class="badge" style="background:{{ $band->status=='aktif'?'#052e16':'#450a0a' }};color:{{ $band->status=='aktif'?'#4ade80':'#f87171' }}">
                            {{ ucfirst($band->status) }}
                        </span>
                    </td>
                    <td class="py-3 flex gap-2">
                        <a href="{{ route('admin.band.edit', $band) }}"
                           class="w-8 h-8 rounded flex items-center justify-center text-sm"
                           style="background:#222;border:1px solid #333;text-decoration:none">✏️</a>
                        <form method="POST" action="{{ route('admin.band.destroy', $band) }}"
                              onsubmit="return confirm('Hapus band {{ $band->nama_band }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-8 h-8 rounded text-sm"
                                style="background:#450a0a;border:1px solid #991b1b">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="py-8 text-center text-gray-500">Tidak ada data band</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $bands->links() }}</div>
</div>
@endsection
