{{-- FILE: resources/views/admin/genre/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Tambah Genre')
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
<div class="mb-2 text-sm text-gray-500">
    <a href="{{ route('admin.genre.index') }}" style="color:#F5A623">Manajemen Genre</a> › Tambah Genre
</div>
<h1 class="text-2xl font-bold text-white mb-5">Tambah Genre Baru</h1>

<div class="card p-6" style="max-width:400px">
    @if($errors->any())
    <div class="mb-4 p-3 rounded-lg text-sm" style="background:#450a0a;color:#f87171">
        {{ $errors->first() }}
    </div>
    @endif
    <form method="POST" action="{{ route('admin.genre.store') }}">
        @csrf
        <div class="mb-4">
            <label class="text-xs font-bold tracking-wider text-gray-500">NAMA GENRE *</label>
            <input type="text" name="nama_genre" value="{{ old('nama_genre') }}"
                placeholder="Contoh: Pop, Rock, Jazz..." class="input-field mt-1" required>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.genre.index') }}" class="btn-outline px-5 py-2 text-sm" style="text-decoration:none">Batal</a>
            <button type="submit" class="btn-primary px-5 py-2 text-sm">Simpan Genre</button>
        </div>
    </form>
</div>
@endsection
