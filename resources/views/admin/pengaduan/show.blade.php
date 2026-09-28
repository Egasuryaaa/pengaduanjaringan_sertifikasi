@extends('layouts.app')

@section('title', 'Detail Aduan ' . $pengaduan->kode_tiket)
@section('page_heading', 'Verifikasi & Tindak Lanjut Aduan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Detail & Riwayat Pengerjaan -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <div class="flex items-center justify-between border-b pb-4 mb-4">
                <div>
                    <span class="text-xs text-slate-400 uppercase font-bold">Kode Tiket</span>
                    <h3 class="text-xl font-black text-blue-600">{{ $pengaduan->kode_tiket }}</h3>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase border bg-slate-50">
                    {{ $pengaduan->status }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-xs mb-4">
                <div>
                    <span class="text-slate-400 block font-semibold">Pelapor</span>
                    <span class="text-slate-700 font-bold">{{ $pengaduan->nama_pelapor }}</span> ({{ $pengaduan->kontak_pelapor }})
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Instansi OPD</span>
                    <span class="text-slate-700 font-bold">{{ $pengaduan->instansi_pelapor ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Kategori</span>
                    <span class="text-slate-700 font-bold">{{ $pengaduan->kategori->nama_kategori }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Lokasi Kejadian</span>
                    <span class="text-slate-700 font-bold">{{ $pengaduan->lokasi }}</span>
                </div>
            </div>

            <div class="border-t pt-4 text-xs">
                <span class="text-slate-400 block font-semibold mb-1">Judul Kendala</span>
                <p class="font-bold text-slate-800 text-sm mb-3">{{ $pengaduan->judul }}</p>
                <span class="text-slate-400 block font-semibold mb-1">Deskripsi Lengkap</span>
                <p class="bg-slate-50 p-3 rounded border text-slate-700 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
            </div>

            <!-- Foto Bukti Pelapor -->
            <div class="border-t pt-4 mt-4">
                <span class="text-xs font-bold text-slate-600 uppercase block mb-2">Lampiran Bukti Awal Pelapor:</span>
                @if($pengaduan->foto_bukti)
                    <a href="{{ asset('storage/' . $pengaduan->foto_bukti) }}" target="_blank">
                        <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}" alt="Bukti Pelapor" class="h-48 rounded-lg border object-cover">
                    </a>
                @else
                    <p class="text-xs text-slate-400 italic">Pelapor tidak menyertakan foto lampiran.</p>
                @endif
            </div>
        </div>

        <!-- Log Audit Tanggapan / Pengerjaan -->
        <div class="bg-white p-6 rounded-xl border shadow-sm">
            <h4 class="font-bold text-slate-700 text-sm mb-4">Riwayat Catatan Penanganan Teknis</h4>
            <div class="space-y-4">
                @forelse($pengaduan->tanggapan as $log)
                    <div class="border rounded-lg p-3 text-xs bg-slate-50">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-slate-800">{{ $log->petugas->name }}</span>
                            <span class="text-slate-400">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <span class="inline-block bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded mb-2">
                            Status: {{ $log->status_sesudahnya }}
                        </span>
                        <p class="text-slate-700">{{ $log->catatan }}</p>
                        @if($log->foto_tindak_lanjut)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $log->foto_tindak_lanjut) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $log->foto_tindak_lanjut) }}" class="h-28 rounded border object-cover">
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">Belum ada tindakan yang dicatat.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Form Aksi ACC / Verifikasi & Tindak Lanjut Lapangan -->
    <div>
        <div class="bg-white p-6 rounded-xl border shadow-sm sticky top-20">
            <h4 class="font-bold text-slate-800 text-sm mb-4 border-b pb-2">Tindakan Petugas Teknis</h4>

            <form action="{{ route('admin.pengaduan.update-status', $pengaduan) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block font-bold text-slate-600 uppercase mb-1">Perbarui Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full border rounded px-3 py-2 border-slate-300">
                        <option value="diverifikasi" {{ $pengaduan->status == 'diverifikasi' ? 'selected' : '' }}>ACC & Diverifikasi</option>
                        <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses (Pengerjaan Teknis)</option>
                        <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Tuntas / Selesai</option>
                        <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Tolak Aduan</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 uppercase mb-1">Tingkat Prioritas</label>
                    <select name="prioritas" class="w-full border rounded px-3 py-2 border-slate-300">
                        <option value="rendah" {{ $pengaduan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ $pengaduan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ $pengaduan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="darurat" {{ $pengaduan->prioritas == 'darurat' ? 'selected' : '' }}>Darurat</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 uppercase mb-1">Catatan Penanganan / Alasan <span class="text-red-500">*</span></label>
                    <textarea name="catatan" rows="4" required placeholder="Tuliskan tindakan perbaikan atau alasan verifikasi..." class="w-full border rounded p-2.5 border-slate-300"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 uppercase mb-1">Upload Bukti Lapangan / Selesai</label>
                    <input type="file" name="foto_tindak_lanjut" accept="image/*" class="w-full text-slate-500 text-[11px]">
                    <span class="text-[10px] text-slate-400 mt-1 block">Foto hasil perbaikan, modem aktif, kabel selesai disambung.</span>
                </div>

                <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-2.5 rounded-lg hover:bg-emerald-700 transition">
                    Simpan & Perbarui Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection