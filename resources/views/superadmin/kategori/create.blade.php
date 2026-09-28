@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page_heading', 'Tambah Kategori Layanan')

@section('content')
<div class="max-w-xl bg-white p-6 rounded-xl border shadow-sm">
    <form action="{{ route('superadmin.kategori.store') }}" method="POST" class="space-y-4 text-xs">
        @csrf
        <div>
            <label class="block font-bold text-slate-600 uppercase mb-1">Nama Kategori Layanan</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Contoh: Infrastruktur Fiber Optik" required class="w-full border rounded px-3 py-2 border-slate-300">
        </div>
        <div>
            <label class="block font-bold text-slate-600 uppercase mb-1">Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="3" placeholder="Penjelasan lingkup kendala kategori ini..." class="w-full border rounded p-2.5 border-slate-300">{{ old('deskripsi') }}</textarea>
        </div>
        <div class="flex gap-2 pt-2">
            <button type="submit" class="bg-blue-600 text-white font-bold px-4 py-2 rounded hover:bg-blue-700">Simpan Kategori</button>
            <a href="{{ route('superadmin.kategori.index') }}" class="bg-slate-200 text-slate-600 px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection