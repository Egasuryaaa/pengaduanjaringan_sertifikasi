@extends('layouts.app')

@section('title', 'Edit Kategori Layanan')
@section('page_heading', 'Ubah Kategori Pengaduan')

@section('content')
<div class="max-w-xl bg-white p-6 rounded-xl border shadow-sm">
    <form action="{{ route('superadmin.kategori.update', $kategori) }}" method="POST" class="space-y-4 text-xs">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-bold text-slate-600 uppercase mb-1">Nama Kategori Layanan</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('nama_kategori') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-bold text-slate-600 uppercase mb-1">Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="3" class="w-full border rounded p-2.5 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-2 pt-2">
            <button type="submit" class="bg-blue-600 text-white font-bold px-4 py-2 rounded hover:bg-blue-700 transition">
                Perbarui Kategori
            </button>
            <a href="{{ route('superadmin.kategori.index') }}" class="bg-slate-200 text-slate-600 px-4 py-2 rounded hover:bg-slate-300 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection