{{-- FILE: resources/views/anggota/hasil.blade.php --}}
@extends('layouts.app')
@section('title', 'Hasil TOPSIS')
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
    <a href="{{ route('anggota.dashboard') }}" style="color:#F5A623">Dashboard</a> ›
    <a href="{{ route('anggota.filter') }}" style="color:#F5A623">Filter Band</a> › Hasil TOPSIS
</div>
<h1 class="text-2xl font-bold text-white mb-1">Hasil Ranking TOPSIS</h1>
<p class="text-gray-400 text-sm mb-5">
    Filter: {{ $sesi->filter_genre ?? 'Semua' }} • {{ $sesi->filter_lokasi ?? 'Semua' }}
    • {{ $sesi->filter_budget ? '≤ Rp '.number_format($sesi->filter_budget) : 'Semua' }}
    | Bobot: Pengalaman={{ $sesi->bobot_pengalaman }}, Popularitas={{ $sesi->bobot_popularitas }}, Biaya={{ $sesi->bobot_biaya }}
</p>

@php $ranking = $sesi->hasil_ranking ?? []; $top = $ranking[0] ?? null; @endphp

{{-- Rekomendasi Terbaik --}}
@if($top)
<div class="p-5 mb-6 rounded-xl" style="background:linear-gradient(135deg,#2a1a00,#1a1200);border:1px solid #3a2800">
    <div class="text-xs font-bold tracking-wider mb-2" style="color:#F5A623">REKOMENDASI TERBAIK</div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="text-4xl">🏆</div>
            <div>
                <div class="text-2xl font-bold text-white">{{ $top['nama_band'] }}</div>
                <div class="text-gray-400 text-sm mt-1">
                    {{ $top['genre'] }} • {{ $top['lokasi'] }} •
                    {{ $top['pengalaman'] }} tahun pengalaman •
                    {{ number_format($top['pengikut']/1000, 0) }}K pengikut
                </div>
                <div class="text-2xl font-bold mt-2" style="color:#F5A623">
                    Ci = {{ number_format($top['ci'], 3) }}
                    <span class="text-sm text-gray-400 font-normal">/1.000</span>
                </div>
            </div>
        </div>
        @php $bandModel = \App\Models\Band::find($top['id']); @endphp
        @if($bandModel)
        <a href="{{ route('anggota.profil-band', $bandModel->id) }}"
           class="px-5 py-2 rounded-lg text-sm font-bold text-black text-center"
           style="background:#F5A623;text-decoration:none;white-space:nowrap">
            Lihat Profil →
        </a>
        @endif
    </div>
</div>
@endif

{{-- Tabel Ranking Lengkap --}}
<div class="card p-5 mb-6">
    <div class="flex items-center gap-3 mb-4">
        <h2 class="font-bold text-white">Tabel Ranking Lengkap</h2>
        <span class="badge text-xs" style="background:#1a2a1a;color:#4ade80">{{ count($ranking) }} Band</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-gray-500 text-xs" style="border-bottom:1px solid #333">
                    <th class="text-left py-2 pr-4">RANK</th>
                    <th class="text-left py-2 pr-4">NAMA BAND</th>
                    <th class="text-left py-2 pr-4">D+ (JARAK KE A+)</th>
                    <th class="text-left py-2 pr-4">D− (JARAK KE A−)</th>
                    <th class="text-left py-2 pr-4">CI (PREFERENSI)</th>
                    <th class="text-left py-2 pr-4">SKOR VISUAL</th>
                    <th class="text-left py-2">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ranking as $r)
                @php $bandM = \App\Models\Band::find($r['id']); @endphp
                <tr class="table-row" style="border-bottom:1px solid #1a1a1a">
                    <td class="py-3 pr-4">
                        <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold"
                            style="background:{{ $r['rank']==1 ? '#F5A623' : ($r['rank']<=3 ? '#333' : '#222') }};color:{{ $r['rank']==1 ? '#000' : '#fff' }}">
                            {{ $r['rank'] }}
                        </span>
                    </td>
                    <td class="py-3 pr-4">
                        <div class="font-semibold text-white">{{ $r['nama_band'] }}</div>
                        <div class="text-xs text-gray-500">{{ $r['genre'] }} • {{ $r['lokasi'] }}</div>
                    </td>
                    <td class="py-3 pr-4 text-gray-300">{{ number_format($r['d_plus'], 3) }}</td>
                    <td class="py-3 pr-4" style="color:#4ade80">{{ number_format($r['d_minus'], 3) }}</td>
                    <td class="py-3 pr-4 font-bold" style="color:#F5A623">{{ number_format($r['ci'], 3) }}</td>
                    <td class="py-3 pr-4">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 rounded-full" style="background:#333;height:6px;min-width:80px">
                                <div class="rounded-full progress-bar" style="width:{{ ($r['ci'] * 100) }}%;height:6px"></div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3">
                        @if($bandM)
                        <a href="{{ route('anggota.profil-band', $bandM->id) }}"
                           class="px-3 py-1 rounded text-xs font-semibold"
                           style="background:#222;color:#E5E7EB;text-decoration:none;border:1px solid #333">
                            Detail
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- A+ A- --}}
@php
    $maxPengalaman = max(array_column($ranking, 'pengalaman'));
    $maxPengikut   = max(array_column($ranking, 'pengikut'));
    $minBiaya      = min(array_column($ranking, 'biaya_sewa'));
    $minPengalaman = min(array_column($ranking, 'pengalaman'));
    $minPengikut   = min(array_column($ranking, 'pengikut'));
    $maxBiaya      = max(array_column($ranking, 'biaya_sewa'));
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="p-4 rounded-xl" style="background:#0d2d1f;border:1px solid #166534">
        <div class="font-bold mb-2" style="color:#4ade80">A+ (Solusi Ideal Positif)</div>
        <div class="text-sm text-gray-300">
            Pengalaman: {{ $maxPengalaman }} thn | Popularitas: {{ number_format($maxPengikut/1000, 0) }}K
            | Biaya: Rp {{ number_format($minBiaya/1000000, 1) }} Jt
        </div>
    </div>
    <div class="p-4 rounded-xl" style="background:#2d0d0d;border:1px solid #991b1b">
        <div class="font-bold mb-2" style="color:#f87171">A− (Solusi Ideal Negatif)</div>
        <div class="text-sm text-gray-300">
            Pengalaman: {{ $minPengalaman }} thn | Popularitas: {{ number_format($minPengikut/1000, 0) }}K
            | Biaya: Rp {{ number_format($maxBiaya/1000000, 1) }} Jt
        </div>
    </div>
</div>

<div class="flex gap-3">
    <a href="{{ route('anggota.filter') }}"
       class="px-6 py-3 rounded-lg text-sm font-semibold"
       style="background:#222;color:#E5E7EB;text-decoration:none;border:1px solid #333">
        ← Filter Ulang
    </a>
</div>
@endsection