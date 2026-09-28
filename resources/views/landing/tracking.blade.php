@extends('layouts.public')

@section('title', 'Lacak Status Pengaduan - Kominfo')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="bg-white p-6 rounded-xl border shadow-sm mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Pelacakan Tiket Aduan</h1>
        <p class="text-xs text-slate-500 mb-6">Masukkan Kode Tiket yang Anda peroleh saat pertama kali mengirim aduan.</p>

        <form action="{{ route('pengaduan.tracking') }}" method="GET" class="max-w-md mx-auto flex gap-2">
            <input type="text" name="tiket" value="{{ $tiket ?? '' }}" placeholder="Contoh: TKT-20260928-ABC12" required class="flex-1 text-sm border rounded-lg px-4 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 uppercase tracking-wider font-semibold">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                Cari
            </button>
        </form>
    </div>

    @if($tiket && !$pengaduan)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 p-6 rounded-xl text-center">
            <i class="fa-solid fa-triangle-exclamation text-2xl text-amber-600 mb-2"></i>
            <p class="font-bold">Kode Tiket "{{ $tiket }}" Tidak Ditemukan</p>
            <p class="text-xs mt-1">Pastikan kode yang dimasukkan tepat dan belum pernah dibatalkan.</p>
        </div>
    @elseif($pengaduan)
        <div class="bg-white rounded-xl border shadow-sm overflow-hidden mb-6">
            <!-- Header Kartu -->
            <div class="bg-slate-50 p-5 border-b flex flex-wrap items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-bold text-slate-400 block uppercase">Nomor Tiket</span>
                    <span class="text-lg font-extrabold text-blue-700 tracking-wider">{{ $pengaduan->kode_tiket }}</span>
                </div>
                <div>
                    @php
                        $badge = [
                            'menunggu'     => 'bg-amber-100 text-amber-800 border-amber-300',
                            'diverifikasi' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                            'diproses'     => 'bg-blue-100 text-blue-800 border-blue-300',
                            'selesai'      => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            'ditolak'      => 'bg-rose-100 text-rose-800 border-rose-300',
                        ][$pengaduan->status];
                    @endphp
                    <span class="text-xs px-3 py-1 rounded-full font-bold uppercase border {{ $badge }}">
                        {{ $pengaduan->status }}
                    </span>
                </div>
            </div>

            <!-- Rincian Data -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-bold text-slate-800 text-base mb-3">{{ $pengaduan->judul }}</h3>
                    <div class="space-y-2 text-xs text-slate-600">
                        <p><strong class="text-slate-700">Pelapor:</strong> {{ $pengaduan->nama_pelapor }} ({{ $pengaduan->instansi_pelapor ?? 'Masyarakat Umum' }})</p>
                        <p><strong class="text-slate-700">Kategori:</strong> {{ $pengaduan->kategori->nama_kategori }}</p>
                        <p><strong class="text-slate-700">Lokasi:</strong> {{ $pengaduan->lokasi }}</p>
                        <p><strong class="text-slate-700">Waktu Lapor:</strong> {{ $pengaduan->created_at->format('d M Y, H:i') }} WIB</p>
                        <p><strong class="text-slate-700">Petugas Penanggung Jawab:</strong> {{ $pengaduan->petugas?->name ?? 'Belum Ditugaskan' }}</p>
                    </div>

                    <div class="mt-4 p-3 bg-slate-50 rounded-lg border text-xs text-slate-700">
                        <strong>Uraian Kendala:</strong>
                        <p class="mt-1 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                    </div>
                </div>

                <!-- Komparasi Foto -->
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-bold text-slate-600 uppercase block mb-1">Foto Bukti Kerusakan Awal:</span>
                        @if($pengaduan->foto_bukti)
                            <a href="{{ asset('storage/' . $pengaduan->foto_bukti) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}" alt="Foto Awal" class="h-44 w-full object-cover rounded-lg border hover:opacity-90">
                            </a>
                        @else
                            <div class="h-28 bg-slate-50 border border-dashed rounded-lg flex items-center justify-center text-xs text-slate-400">
                                Tidak ada foto terlampir saat pelaporan awal.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline Tanggapan / Pengerjaan -->
            <div class="border-t p-6 bg-slate-50">
                <h4 class="font-bold text-slate-800 text-sm mb-4">Catatan Perkembangan & Tindak Lanjut Teknis</h4>
                @if($pengaduan->tanggapan->isEmpty())
                    <p class="text-xs text-slate-400 italic">Belum ada catatan tindak lanjut dari petugas verifikator.</p>
                @else
                    <ol class="relative border-l border-blue-300 ml-3 space-y-4">
                        @foreach($pengaduan->tanggapan as $log)
                            <li class="mb-4 ml-4">
                                <div class="absolute w-3 h-3 bg-blue-600 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <time class="mb-1 text-xs font-normal text-slate-400">{{ $log->created_at->format('d M Y, H:i') }} WIB</time>
                                <h5 class="text-xs font-bold text-slate-800">
                                    Petugas: {{ $log->petugas->name }} 
                                    <span class="ml-2 font-normal bg-slate-200 px-2 py-0.5 rounded text-[11px]">
                                        Status: {{ $log->status_sesudahnya }}
                                    </span>
                                </h5>
                                <p class="text-xs text-slate-600 mt-1 bg-white p-2.5 rounded border">{{ $log->catatan }}</p>
                                @if($log->foto_tindak_lanjut)
                                    <div class="mt-2">
                                        <span class="text-[11px] font-semibold text-slate-500 block mb-1">Foto Bukti Pengerjaan Lapangan:</span>
                                        <a href="{{ asset('storage/' . $log->foto_tindak_lanjut) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $log->foto_tindak_lanjut) }}" class="h-32 rounded border object-cover">
                                        </a>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection