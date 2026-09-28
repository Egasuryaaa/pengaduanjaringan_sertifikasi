@extends('layouts.app')

@section('title', 'Verifikasi Pengaduan')
@section('page_heading', 'Verifikasi & Penanganan Tiket Masuk')

@section('content')
<!-- Filter Box -->
<div class="bg-white p-4 rounded-xl border shadow-sm mb-6">
    <form action="{{ route('admin.pengaduan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
        <div>
            <label class="block font-bold text-slate-600 uppercase mb-1">Cari Tiket / Pelapor</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..." class="w-full border rounded px-3 py-2 border-slate-300">
        </div>
        <div>
            <label class="block font-bold text-slate-600 uppercase mb-1">Filter Status</label>
            <select name="status" class="w-full border rounded px-3 py-2 border-slate-300">
                <option value="">Semua Status</option>
                @foreach(['menunggu', 'diverifikasi', 'diproses', 'selesai', 'ditolak'] as $st)
                    <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-bold text-slate-600 uppercase mb-1">Filter Kategori</label>
            <select name="kategori_id" class="w-full border rounded px-3 py-2 border-slate-300">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-blue-600 text-white font-bold px-4 py-2 rounded hover:bg-blue-700 w-full">Filter Data</button>
            <a href="{{ route('admin.pengaduan.index') }}" class="bg-slate-200 text-slate-600 px-3 py-2 rounded text-center">Reset</a>
        </div>
    </form>
</div>

<!-- Tabel Data -->
<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b text-slate-500 uppercase font-semibold">
                <tr>
                    <th class="p-3">Tiket</th>
                    <th class="p-3">Pelapor & OPD</th>
                    <th class="p-3">Judul / Kendala</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Prioritas</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y text-slate-700">
                @forelse($pengaduan as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold text-blue-600 whitespace-nowrap">{{ $item->kode_tiket }}</td>
                        <td class="p-3">
                            <span class="font-bold">{{ $item->nama_pelapor }}</span>
                            <span class="block text-[11px] text-slate-400">{{ $item->instansi_pelapor ?? 'Umum' }}</span>
                        </td>
                        <td class="p-3 max-w-xs font-medium">{{ $item->judul }}</td>
                        <td class="p-3">{{ $item->kategori->nama_kategori }}</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] 
                                {{ $item->prioritas == 'darurat' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $item->prioritas }}
                            </span>
                        </td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-slate-100 border">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="p-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.pengaduan.show', $item) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold px-3 py-1.5 rounded">
                                Proses / ACC
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">Tidak ada pengaduan yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">
        {{ $pengaduan->links() }}
    </div>
</div>
@endsection