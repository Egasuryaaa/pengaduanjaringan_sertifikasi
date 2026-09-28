@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')
@section('page_heading', 'Ringkasan Sistem')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-xl border shadow-sm">
        <span class="text-xs uppercase font-bold text-slate-400">Total Tiket Masuk</span>
        <div class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total_pengaduan'] }}</div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-amber-200 shadow-sm bg-amber-50/30">
        <span class="text-xs uppercase font-bold text-amber-700">Menunggu Verifikasi</span>
        <div class="text-2xl font-black text-amber-600 mt-1">{{ $stats['menunggu'] }}</div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-blue-200 shadow-sm bg-blue-50/30">
        <span class="text-xs uppercase font-bold text-blue-700">Sedang Diproses</span>
        <div class="text-2xl font-black text-blue-600 mt-1">{{ $stats['diproses'] }}</div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-emerald-200 shadow-sm bg-emerald-50/30">
        <span class="text-xs uppercase font-bold text-emerald-700">Tuntas Selesai</span>
        <div class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['selesai'] }}</div>
    </div>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h3 class="font-bold text-slate-700 text-sm">Tiket Aduan Masuk Terbaru</h3>
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
            <a href="{{ route('admin.pengaduan.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                Lihat Semua Tiket &rarr;
            </a>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b text-slate-500 uppercase font-semibold">
                <tr>
                    <th class="p-3">Tiket</th>
                    <th class="p-3">Pelapor</th>
                    <th class="p-3">Judul Kendala</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y text-slate-700">
                @forelse($aduanTerbaru as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold text-blue-600">{{ $item->kode_tiket }}</td>
                        <td class="p-3">{{ $item->nama_pelapor }}</td>
                        <td class="p-3 max-w-xs truncate">{{ $item->judul }}</td>
                        <td class="p-3">{{ $item->kategori->nama_kategori }}</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-bold uppercase bg-slate-100 border">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="p-3 text-slate-400">{{ $item->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-400">Belum ada aduan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection