{{-- FILE: resources/views/admin/genre/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Genre')
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
<h1 class="text-2xl font-bold text-white mb-5">Edit Genre: {{ $genre->nama_genre }}</h1>
<div class="card p-6" style="max-width:400px">
    <form method="POST" action="{{ route('admin.genre.update', $genre) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="text-xs font-bold tracking-wider text-gray-500">NAMA GENRE *</label>
            <input type="text" name="nama_genre" value="{{ old('nama_genre', $genre->nama_genre) }}" class="input-field mt-1" required>
        </div>
        <div class="mb-5">
            <label class="text-xs font-bold tracking-wider text-gray-500">STATUS</label>
            <select name="status" class="input-field mt-1">
                <option value="aktif" {{ $genre->status=='aktif'?'selected':'' }}>Aktif</option>
                <option value="tidak_aktif" {{ $genre->status=='tidak_aktif'?'selected':'' }}>Tidak Aktif</option>
            </select>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.genre.index') }}" class="btn-outline px-5 py-2 text-sm" style="text-decoration:none">Batal</a>
            <button type="submit" class="btn-primary px-5 py-2 text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
