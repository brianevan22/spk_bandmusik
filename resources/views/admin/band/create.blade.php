{{-- FILE: resources/views/admin/band/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Tambah Band')
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
<div class="mb-2 text-sm text-gray-500">
    <a href="{{ route('admin.band.index') }}" style="color:#F5A623">Manajemen Band</a> › Tambah Band
</div>
<h1 class="text-2xl font-bold text-white mb-5">Tambah Band Baru</h1>

<div class="card p-6" style="max-width:700px">
    @if($errors->any())
    <div class="mb-4 p-3 rounded-lg text-sm" style="background:#450a0a;color:#f87171;border:1px solid #991b1b">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.band.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">NAMA BAND *</label>
                <input type="text" name="nama_band" value="{{ old('nama_band') }}" class="input-field mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">EMAIL (untuk login) *</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input-field mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">PASSWORD *</label>
                <input type="password" name="password" class="input-field mt-1" required minlength="8">
            </div>
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">GENRE *</label>
                <select name="genre_id" class="input-field mt-1" required>
                    <option value="">Pilih Genre</option>
                    @foreach($genres as $g)
                    <option value="{{ $g->id }}" {{ old('genre_id')==$g->id?'selected':'' }}>{{ $g->nama_genre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">LOKASI / KOTA *</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="input-field mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">TAHUN BERDIRI *</label>
                <input type="number" name="tahun_berdiri" value="{{ old('tahun_berdiri', 2015) }}"
                    min="1900" max="{{ now()->year }}" class="input-field mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">JUMLAH PENGIKUT *</label>
                <input type="number" name="pengikut" value="{{ old('pengikut', 0) }}" min="0" class="input-field mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold tracking-wider text-gray-500">BIAYA SEWA (RP) *</label>
                <input type="number" name="biaya_sewa" value="{{ old('biaya_sewa') }}" min="0" class="input-field mt-1" required>
            </div>
        </div>
        <div class="mt-4">
            <label class="text-xs font-bold tracking-wider text-gray-500">DESKRIPSI BAND</label>
            <textarea name="deskripsi" rows="3" class="input-field mt-1" placeholder="Deskripsi singkat tentang band...">{{ old('deskripsi') }}</textarea>
        </div>
        <div class="flex gap-3 mt-6">
            <a href="{{ route('admin.band.index') }}" class="btn-outline px-6 py-2 text-sm" style="text-decoration:none">Batal</a>
            <button type="submit" class="btn-primary px-6 py-2 text-sm">Simpan Band</button>
        </div>
    </form>
</div>
@endsection
