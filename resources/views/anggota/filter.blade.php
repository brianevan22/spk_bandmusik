{{-- FILE: resources/views/anggota/filter.blade.php --}}
@extends('layouts.app')
@section('title', 'Cari & Filter Band')
@section('sidebar-subtitle', 'Sistem Pendukung Keputusan')

@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">MENU UTAMA</div>
<a href="{{ route('anggota.dashboard') }}" class="nav-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
<a href="{{ route('anggota.filter') }}" class="nav-link {{ request()->routeIs('anggota.filter*') ? 'active' : '' }}">🔍 Cari & Filter Band</a>

@if(session('last_sesi_id'))
    <a href="{{ route('anggota.hasil', session('last_sesi_id')) }}"
       class="nav-link {{ request()->routeIs('anggota.hasil*') ? 'active' : '' }}">
        📊 Hasil TOPSIS
    </a>
@else
    <span class="nav-link" style="opacity:0.35;cursor:not-allowed" title="Jalankan TOPSIS dulu">
        📊 Hasil TOPSIS
    </span>
@endif

@if(session('last_band_id'))
    <a href="{{ route('anggota.profil-band', session('last_band_id')) }}"
       class="nav-link {{ request()->routeIs('anggota.profil-band*') ? 'active' : '' }}">
        🎵 Profil Band
    </a>
@else
    <span class="nav-link" style="opacity:0.35;cursor:not-allowed" title="Pilih band dari hasil TOPSIS">
        🎵 Profil Band
    </span>
@endif
@endsection

@section('content')
<div class="mb-2 text-sm text-gray-500">
    <a href="{{ route('anggota.dashboard') }}" style="color:#F5A623">Dashboard</a> › Cari & Filter Band
</div>
<h1 class="text-2xl font-bold text-white mb-1">Filter & Perhitungan TOPSIS</h1>
<p class="text-gray-400 text-sm mb-6">Tentukan kriteria pencarian dan bobot prioritas sebelum menjalankan algoritma TOPSIS.</p>

<form method="POST" action="{{ route('anggota.filter.apply') }}" id="filterForm">
@csrf

{{-- Step 1: Filter --}}
<div class="card p-6 mb-5">
    <div class="flex items-center gap-3 mb-5">
        <span class="w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold text-black" style="background:#F5A623">1</span>
        <h2 class="font-bold text-white">Filter Pencarian Band</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="text-xs font-bold tracking-wider text-gray-500">GENRE MUSIK</label>
            <select name="genre" class="input-field mt-1">
                <option value="">Semua Genre</option>
                @foreach($genres as $g)
                <option value="{{ $g->id }}" {{ ($savedFilter['genre'] ?? '') == $g->id ? 'selected' : '' }}>
                    {{ $g->nama_genre }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs font-bold tracking-wider text-gray-500">LOKASI / KOTA</label>
            <select name="lokasi" class="input-field mt-1">
                <option value="">Semua Kota</option>
                @foreach($lokasi as $l)
                <option value="{{ $l }}" {{ ($savedFilter['lokasi'] ?? '') == $l ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs font-bold tracking-wider text-gray-500">BUDGET MAKSIMUM</label>
            <input type="number" name="budget" placeholder="≤ Rp 8.000.000"
                value="{{ $savedFilter['budget'] ?? '' }}" class="input-field mt-1">
        </div>
    </div>
    <button type="submit" class="mt-4 px-6 py-2 rounded-lg text-sm font-semibold text-white" style="background:#333;border:1px solid #444">
        🔍 Terapkan Filter
    </button>
</div>
</form>

@isset($bands)
{{-- Step 2: Bobot TOPSIS --}}
<form method="POST" action="{{ route('anggota.topsis.run') }}" id="topsisForm">
@csrf

{{-- Kirim filter genre sebagai nama (untuk ditampilkan di hasil) --}}
<input type="hidden" name="filter_genre"
    value="{{ !empty($savedFilter['genre']) ? ($genres->find($savedFilter['genre'])->nama_genre ?? '') : '' }}">
<input type="hidden" name="filter_lokasi"  value="{{ $savedFilter['lokasi'] ?? '' }}">
<input type="hidden" name="filter_budget"  value="{{ $savedFilter['budget'] ?? '' }}">

{{-- Bobot — nilai awal diambil dari session jika ada --}}
<input type="hidden" name="bobot_pengalaman"  id="h_pengalaman"  value="{{ $savedBobot['pengalaman']  ?? 5 }}">
<input type="hidden" name="bobot_popularitas" id="h_popularitas" value="{{ $savedBobot['popularitas'] ?? 4 }}">
<input type="hidden" name="bobot_biaya"       id="h_biaya"       value="{{ $savedBobot['biaya']       ?? 3 }}">

<div class="card p-6 mb-5">
    <div class="flex items-center gap-3 mb-2">
        <span class="w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold text-black" style="background:#F5A623">2</span>
        <h2 class="font-bold text-white">Input Bobot Kriteria TOPSIS</h2>
        <span class="badge text-xs" style="background:#1a2a3a;color:#60a5fa">Skala 1-10</span>
    </div>

    @if($bands->count() < 2)
    <div class="p-3 rounded-lg text-sm mb-4" style="background:#2a1a00;color:#fbbf24;border:1px solid #92400e">
        ⚠️ Minimal 2 band diperlukan untuk menjalankan TOPSIS. Longgarkan filter Anda.
    </div>
    @else
    <div class="p-3 rounded-lg text-sm mb-5" style="background:#2a1a00;color:#fbbf24;border:1px solid #92400e">
        ⚠️ Semua bobot harus diisi. Bobot menentukan prioritas kriteria dalam perhitungan TOPSIS.
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold tracking-wider text-gray-400">PENGALAMAN (TAHUN BERDIRI)</span>
                <span class="text-xs text-gray-500">Benefit +</span>
            </div>
            <div class="text-3xl font-bold text-white mb-3" id="val_pengalaman">{{ $savedBobot['pengalaman'] ?? 5 }}</div>
            <input type="range" min="1" max="10" value="{{ $savedBobot['pengalaman'] ?? 5 }}" class="slider-input w-full"
                oninput="updateBobot('pengalaman', this.value)">
        </div>
        <div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold tracking-wider text-gray-400">POPULARITAS (PENGIKUT)</span>
                <span class="text-xs text-gray-500">Benefit +</span>
            </div>
            <div class="text-3xl font-bold text-white mb-3" id="val_popularitas">{{ $savedBobot['popularitas'] ?? 4 }}</div>
            <input type="range" min="1" max="10" value="{{ $savedBobot['popularitas'] ?? 4 }}" class="slider-input w-full"
                oninput="updateBobot('popularitas', this.value)">
        </div>
        <div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold tracking-wider text-gray-400">BIAYA SEWA</span>
                <span class="text-xs text-red-400">Cost ↓</span>
            </div>
            <div class="text-3xl font-bold text-white mb-3" id="val_biaya">{{ $savedBobot['biaya'] ?? 3 }}</div>
            <input type="range" min="1" max="10" value="{{ $savedBobot['biaya'] ?? 3 }}" class="slider-input w-full"
                oninput="updateBobot('biaya', this.value)">
        </div>
    </div>
</div>

{{-- Step 3: Band Results --}}
<div class="card p-6 mb-6">
    <div class="flex items-center gap-3 mb-4">
        <span class="w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold text-black" style="background:#F5A623">3</span>
        <h2 class="font-bold text-white">Band yang Memenuhi Filter</h2>
        <span class="badge text-xs" style="background:#1a2a1a;color:#4ade80">{{ $bands->count() }} band ditemukan</span>
    </div>
    @if($bands->count() == 0)
        <div class="text-center py-8 text-gray-500">
            <div class="text-4xl mb-3">🔍</div>
            <p>Tidak ada band yang sesuai filter. Coba ubah kriteria pencarian.</p>
        </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500" style="border-bottom:1px solid #333">
                    <th class="text-left py-2 pr-2 w-8"><input type="checkbox" id="checkAll" onchange="toggleAll(this)" class="rounded"></th>
                    <th class="text-left py-2 pr-4">NAMA BAND</th>
                    <th class="text-left py-2 pr-4">GENRE</th>
                    <th class="text-left py-2 pr-4">LOKASI</th>
                    <th class="text-left py-2 pr-4">PENGALAMAN</th>
                    <th class="text-left py-2 pr-4">PENGIKUT</th>
                    <th class="text-left py-2">BIAYA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bands as $band)
                <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                    <td class="py-3 pr-2">
                        <input type="checkbox" name="band_ids[]" value="{{ $band->id }}" class="band-check rounded" checked>
                    </td>
                    <td class="py-3 pr-4 font-semibold text-white">{{ $band->nama_band }}</td>
                    <td class="py-3 pr-4">
                        <span class="badge" style="background:#1a2a4a;color:#60a5fa">{{ $band->genre->nama_genre ?? '-' }}</span>
                    </td>
                    <td class="py-3 pr-4 text-gray-300">{{ $band->lokasi }}</td>
                    <td class="py-3 pr-4 text-gray-300">{{ now()->year - $band->tahun_berdiri }} thn</td>
                    <td class="py-3 pr-4 text-gray-300">{{ number_format($band->pengikut/1000, 0) }}K</td>
                    <td class="py-3 text-gray-300">Rp {{ number_format($band->biaya_sewa/1000000, 1) }} Jt</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@if($bands->count() >= 2)
<div class="flex flex-col md:flex-row gap-3">
    <a href="{{ route('anggota.filter.reset') }}"
       class="flex-1 text-center py-3 rounded-lg text-sm font-semibold"
       style="background:#222;color:#E5E7EB;text-decoration:none;border:1px solid #333">
        ← Reset Filter
    </a>
    <button type="submit" form="topsisForm"
        class="flex-1 py-3 rounded-lg text-sm font-bold text-black"
        style="background:#F5A623;border:none;cursor:pointer">
        ⚡ Jalankan TOPSIS →
    </button>
</div>
@endif

</form>
@endisset
@endsection

@push('scripts')
<script>
function updateBobot(key, val) {
    document.getElementById('val_' + key).textContent = val;
    document.getElementById('h_' + key).value = val;
}
function toggleAll(cb) {
    document.querySelectorAll('.band-check').forEach(c => c.checked = cb.checked);
}
</script>
@endpush