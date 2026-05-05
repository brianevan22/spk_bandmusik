{{-- FILE: resources/views/anggota/profil-band.blade.php --}}
@extends('layouts.app')
@section('title', $band->nama_band)
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

{{-- Profil Band: aktif karena sedang di halaman ini --}}
<a href="#" class="nav-link active">🎵 Profil Band</a>
@endsection

@section('content')
<div class="mb-4">
    <a href="javascript:history.back()" style="color:#F5A623;text-decoration:none;font-size:14px">← Kembali</a>
</div>

{{-- Hero --}}
<div class="card p-6 mb-5">
    <div class="flex flex-col md:flex-row items-start md:items-center gap-5">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl font-bold text-white flex-shrink-0"
            style="background:linear-gradient(135deg,#7C3AED,#5b21b6)">
            {{ $band->inisial }}
        </div>
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-3 mb-1">
                <h1 class="text-2xl font-bold text-white">{{ $band->nama_band }}</h1>
                <span class="badge text-xs" style="background:#052e16;color:#4ade80">✓ Aktif</span>
            </div>
            <div class="flex flex-wrap gap-3 text-sm text-gray-400">
                <span>🎵 {{ $band->genre->nama_genre ?? '-' }}</span>
                <span>📍 {{ $band->lokasi }}</span>
                <span>📅 Berdiri {{ $band->tahun_berdiri }} ({{ $band->pengalaman }} tahun)</span>
            </div>
        </div>
    </div>
</div>

{{-- Stat Row --}}
<div class="grid grid-cols-3 gap-4 mb-5">
    <div class="card p-5 text-center">
        <div class="text-2xl font-bold" style="color:#F5A623">{{ number_format($band->pengikut/1000, 0) }}K</div>
        <div class="text-gray-400 text-xs mt-1">PENGIKUT</div>
    </div>
    <div class="card p-5 text-center">
        <div class="text-2xl font-bold text-white">{{ $band->pengalaman }}</div>
        <div class="text-gray-400 text-xs mt-1">THN PENGALAMAN</div>
    </div>
    <div class="card p-5 text-center">
        <div class="text-2xl font-bold" style="color:#F5A623">Rp {{ number_format($band->biaya_sewa/1000000, 1) }} Jt</div>
        <div class="text-gray-400 text-xs mt-1">BIAYA SEWA</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    {{-- Tentang --}}
    <div class="lg:col-span-2">
        <div class="card p-5 mb-5">
            <h2 class="font-bold text-white mb-3">Tentang {{ $band->nama_band }}</h2>
            <p class="text-gray-400 text-sm leading-relaxed">
                {{ $band->deskripsi ?? $band->nama_band.' adalah band '.$band->genre->nama_genre.' asal '.$band->lokasi.' yang berdiri pada tahun '.$band->tahun_berdiri.'.' }}
            </p>
        </div>

        {{-- Skor TOPSIS jika ada --}}
        @php
            $sesiTerakhir = \App\Models\SesiTopsis::whereJsonContains('hasil_ranking', [['id' => $band->id]])->latest()->first();
            $skorBand = null;
            if ($sesiTerakhir) {
                foreach ($sesiTerakhir->hasil_ranking as $r) {
                    if ($r['id'] == $band->id) { $skorBand = $r; break; }
                }
            }
        @endphp
        @if($skorBand)
        <div class="card p-5">
            <h2 class="font-bold text-white mb-4">Skor TOPSIS</h2>
            <div class="grid grid-cols-3 gap-3">
                <div class="p-4 rounded-xl text-center" style="background:#222">
                    <div class="text-xl font-bold" style="color:#F5A623">{{ number_format($skorBand['d_plus'], 3) }}</div>
                    <div class="text-xs text-gray-500 mt-1">D+ (Jarak ke A+)</div>
                </div>
                <div class="p-4 rounded-xl text-center" style="background:#222">
                    <div class="text-xl font-bold" style="color:#4ade80">{{ number_format($skorBand['d_minus'], 3) }}</div>
                    <div class="text-xs text-gray-500 mt-1">D− (Jarak ke A−)</div>
                </div>
                <div class="p-4 rounded-xl text-center" style="background:#2a1a00">
                    <div class="text-xl font-bold" style="color:#F5A623">{{ number_format($skorBand['ci'], 3) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Ci (Preferensi)</div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Informasi Kontak --}}
    <div class="card p-5 flex flex-col gap-3">
        <h2 class="font-bold text-white mb-1">Informasi Kontak</h2>
        <div class="flex justify-between text-sm py-2" style="border-bottom:1px solid #222">
            <span class="text-gray-500">Genre</span>
            <span class="text-white font-semibold">{{ $band->genre->nama_genre ?? '-' }}</span>
        </div>
        <div class="flex justify-between text-sm py-2" style="border-bottom:1px solid #222">
            <span class="text-gray-500">Lokasi</span>
            <span class="text-white">{{ $band->lokasi }}</span>
        </div>
        <div class="flex justify-between text-sm py-2" style="border-bottom:1px solid #222">
            <span class="text-gray-500">Tahun Berdiri</span>
            <span class="text-white">{{ $band->tahun_berdiri }}</span>
        </div>
        <div class="flex justify-between text-sm py-2" style="border-bottom:1px solid #222">
            <span class="text-gray-500">Pengikut</span>
            <span class="text-white">{{ number_format($band->pengikut) }}</span>
        </div>
        <div class="flex justify-between text-sm py-2 mb-3">
            <span class="text-gray-500">Biaya Sewa</span>
            <span class="font-bold" style="color:#F5A623">Rp {{ number_format($band->biaya_sewa) }}</span>
        </div>

        @if($band->user && $band->user->email)
        <a href="mailto:{{ $band->user->email }}"
           class="block text-center py-3 rounded-lg text-sm font-bold text-black"
           style="background:#F5A623;text-decoration:none">
            📩 Hubungi Band
        </a>
        @endif
    </div>
</div>
@endsection