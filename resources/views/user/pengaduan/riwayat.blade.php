@extends('layouts.app')

@section('title', 'Riwayat Aduan Saya')
@section('page_heading', 'Riwayat Pengaduan Saya')

@section('content')
<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h3 class="font-bold text-sm text-slate-700">Daftar Tiket yang Pernah Anda Ajukan</h3>
        <a href="{{ route('landing') }}" class="bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-blue-700 font-semibold">
            + Buat Aduan Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b text-slate-500 uppercase font-semibold">
                <tr>
                    <th class="p-3">Kode Tiket</th>
                    <th class="p-3">Judul Kendala</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Petugas</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y text-slate-700">
                @forelse($pengaduanSaya as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold text-blue-600">{{ $item->kode_tiket }}</td>
                        <td class="p-3 font-semibold">{{ $item->judul }}</td>
                        <td class="p-3">{{ $item->kategori->nama_kategori }}</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-bold uppercase border">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="p-3">{{ $item->petugas?->name ?? '-' }}</td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('pengaduan.tracking', ['tiket' => $item->kode_tiket]) }}" target="_blank" class="text-blue-600 hover:underline font-semibold">
                                Cek Progres
                            </a>
                            @if($item->status === 'menunggu')
                                <form action="{{ route('user.pengaduan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan laporan aduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 font-semibold ml-2">Batalkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">Anda belum pernah membuat aduan gangguan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">
        {{ $pengaduanSaya->links() }}
    </div>
</div>
@endsection