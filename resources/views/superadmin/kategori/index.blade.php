@extends('layouts.app')

@section('title', 'Kategori Layanan Aduan')
@section('page_heading', 'Master Kategori Pengaduan')

@section('content')
<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h3 class="font-bold text-sm text-slate-700">Kategori Permasalahan Kominfo</h3>
        <a href="{{ route('superadmin.kategori.create') }}" class="bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-700">
            + Tambah Kategori
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b text-slate-500 uppercase font-semibold">
                <tr>
                    <th class="p-3">Nama Kategori</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Jumlah Aduan</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y text-slate-700">
                @foreach($kategori as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold">{{ $item->nama_kategori }}</td>
                        <td class="p-3 text-slate-400">{{ $item->slug }}</td>
                        <td class="p-3 text-slate-600">{{ $item->deskripsi ?? '-' }}</td>
                        <td class="p-3 font-semibold">{{ $item->pengaduan_count }} Tiket</td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('superadmin.kategori.edit', $item) }}" class="text-blue-600 font-semibold hover:underline">Edit</a>
                            <form action="{{ route('superadmin.kategori.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 font-semibold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">
        {{ $kategori->links() }}
    </div>
</div>
@endsection