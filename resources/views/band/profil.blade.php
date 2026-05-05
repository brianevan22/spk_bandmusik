{{-- FILE: resources/views/band/profil.blade.php --}}
@extends('layouts.app')
@section('title', 'Profil Saya')
@section('sidebar-subtitle', 'Portal Band Musik')
@section('sidebar-nav')
<div class="text-xs text-gray-600 mb-2 font-semibold tracking-wider">MENU BAND</div>
<a href="{{ route('band.dashboard') }}" class="nav-link">🏠 Dashboard</a>
<a href="{{ route('band.profil') }}" class="nav-link active">👤 Profil Saya</a>
<a href="{{ route('band.statistik') }}" class="nav-link">📊 Statistik & Ranking</a>
@endsection
@section('content')
<div class="mb-2 text-sm text-gray-500">
    <a href="{{ route('band.dashboard') }}" style="color:#F5A623">Dashboard</a> › Profil Saya
</div>
<h1 class="text-2xl font-bold text-white mb-1">Kelola Profil Band</h1>
<p class="text-gray-400 text-sm mb-5">Perbarui data profil band Anda. Perubahan akan tercermin dalam perhitungan TOPSIS berikutnya.</p>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Form --}}
    <div class="lg:col-span-2 card p-6">
        @if($errors->any())
        <div class="mb-4 p-3 rounded-lg text-sm" style="background:#450a0a;color:#f87171">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <div class="p-3 rounded-lg text-sm mb-5" style="background:#2a1a00;color:#fbbf24;border:1px solid #92400e">
            ⚠️ Data di bawah ini digunakan langsung dalam perhitungan TOPSIS. Pastikan akurat.
        </div>

        <form method="POST" action="{{ route('band.profil.update') }}">
            @csrf @method('PUT')

            <h3 class="font-bold text-white mb-3">Informasi Dasar Band</h3>
            <div class="mb-4">
                <label class="text-xs font-bold tracking-wider text-gray-500">NAMA BAND</label>
                <input type="text" name="nama_band" value="{{ old('nama_band', $band->nama_band ?? '') }}" class="input-field mt-1" required>
            </div>
            <div class="mb-4">
                <label class="text-xs font-bold tracking-wider text-gray-500">GENRE MUSIK</label>
                <select name="genre_id" class="input-field mt-1" required>
                    @foreach($genres as $g)
                    <option value="{{ $g->id }}" {{ old('genre_id', $band->genre_id ?? '') == $g->id ? 'selected' : '' }}>
                        {{ $g->nama_genre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="text-xs font-bold tracking-wider text-gray-500">LOKASI / KOTA</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $band->lokasi ?? '') }}" class="input-field mt-1" required>
            </div>
            <div class="mb-5">
                <label class="text-xs font-bold tracking-wider text-gray-500">TAHUN BERDIRI</label>
                <input type="number" name="tahun_berdiri" value="{{ old('tahun_berdiri', $band->tahun_berdiri ?? 2015) }}"
                    min="1900" max="{{ now()->year }}" class="input-field mt-1" required>
            </div>

            <h3 class="font-bold text-white mb-3 mt-5">Kriteria TOPSIS</h3>
            <div class="mb-4">
                <label class="text-xs font-bold tracking-wider text-gray-500">JUMLAH PENGIKUT (SOSIAL MEDIA)</label>
                <input type="number" name="pengikut" value="{{ old('pengikut', $band->pengikut ?? 0) }}" min="0" class="input-field mt-1" required>
            </div>
            <div class="mb-4">
                <label class="text-xs font-bold tracking-wider text-gray-500">BIAYA SEWA (RP)</label>
                <input type="number" name="biaya_sewa" value="{{ old('biaya_sewa', $band->biaya_sewa ?? 0) }}" min="0" class="input-field mt-1" required>
            </div>
            <div class="mb-5">
                <label class="text-xs font-bold tracking-wider text-gray-500">DESKRIPSI BAND</label>
                <textarea name="deskripsi" rows="3" class="input-field mt-1">{{ old('deskripsi', $band->deskripsi ?? '') }}</textarea>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('band.dashboard') }}" class="btn-outline px-6 py-2 text-sm" style="text-decoration:none">Batal</a>
                <button type="submit" class="btn-primary px-6 py-2 text-sm">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>

    {{-- Preview Profil --}}
    @if($band)
    <div class="space-y-4">
        <div class="card p-5">
            <h3 class="font-bold text-white mb-3 text-sm">Pratinjau Profil</h3>
            <div class="rounded-xl p-4 mb-3" style="background:#222">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-white"
                        style="background:linear-gradient(135deg,#7C3AED,#5b21b6)">
                        {{ $band->inisial }}
                    </div>
                    <div>
                        <div class="font-bold text-white text-sm">{{ $band->nama_band }}</div>
                        <div class="text-xs text-gray-400">🎵 {{ $band->genre->nama_genre ?? '-' }} • 📍 {{ $band->lokasi }} • 📅 {{ $band->tahun_berdiri }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center text-xs">
                    <div><div class="font-bold" style="color:#F5A623">{{ number_format($band->pengikut/1000, 0) }}K</div><div class="text-gray-500">Pengikut</div></div>
                    <div><div class="font-bold text-white">{{ $band->pengalaman }}</div><div class="text-gray-500">Thn Exp</div></div>
                    <div><div class="font-bold" style="color:#F5A623">{{ number_format($band->biaya_sewa/1000000, 1) }} Jt</div><div class="text-gray-500">Biaya</div></div>
                </div>
            </div>
            <div class="text-xs text-center text-gray-500">Tampilan profil publik yang dilihat Anggota</div>
        </div>

        <div class="card p-5">
            <h3 class="font-bold text-white mb-3 text-sm">Dampak ke Skor TOPSIS</h3>
            <div class="space-y-3">
                @php $exp = $band->pengalaman; @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-400">Pengalaman (Benefit +)</span>
                        <span style="color:{{ $exp >= 5 ? '#4ade80' : '#fbbf24' }}">{{ $exp >= 8 ? 'Tinggi' : ($exp >= 5 ? 'Sedang-Tinggi' : 'Rendah') }}</span>
                    </div>
                    <div style="background:#333;height:6px;border-radius:3px">
                        <div style="background:#4ade80;height:6px;border-radius:3px;width:{{ min(($exp/15)*100, 100) }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-400">Popularitas (Benefit +)</span>
                        <span style="color:{{ $band->pengikut >= 50000 ? '#4ade80' : '#fbbf24' }}">{{ $band->pengikut >= 100000 ? 'Tinggi' : ($band->pengikut >= 50000 ? 'Sedang-Tinggi' : 'Rendah') }}</span>
                    </div>
                    <div style="background:#333;height:6px;border-radius:3px">
                        <div style="background:#F5A623;height:6px;border-radius:3px;width:{{ min(($band->pengikut/200000)*100, 100) }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-400">Biaya (Cost ↓)</span>
                        <span style="color:{{ $band->biaya_sewa <= 5000000 ? '#4ade80' : '#f87171' }}">{{ $band->biaya_sewa <= 3000000 ? 'Kompetitif' : ($band->biaya_sewa <= 6000000 ? 'Sedang' : 'Kurang Kompetitif') }}</span>
                    </div>
                    <div style="background:#333;height:6px;border-radius:3px">
                        <div style="background:#f87171;height:6px;border-radius:3px;width:{{ min(($band->biaya_sewa/15000000)*100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
