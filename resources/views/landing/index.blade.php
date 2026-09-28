@extends('layouts.public')

@section('title', 'Layanan Pengaduan Gangguan Jaringan & SPBE - Kominfo')

@section('content')
<section class="bg-gradient-to-b from-blue-900 to-slate-900 text-white py-14">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 rounded-full uppercase font-bold tracking-widest inline-block mb-3">Layanan Cepat Tanggap</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Pengaduan Gangguan Jaringan & SPBE</h1>
        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
            Sampaikan permasalahan koneksi Fiber Optic, server aplikasi, atau fasilitas jaringan OPD Anda secara langsung. Tim teknis Kominfo siap menindaklanjuti.
        </p>
    </div>
</section>

<div class="max-w-3xl mx-auto px-4 -mt-8 mb-16">
    <div class="bg-white rounded-xl shadow-lg border p-6 sm:p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-1">Formulir Laporan Kendala</h2>
        <p class="text-xs text-slate-500 mb-6">Isi informasi berikut dengan akurat untuk mempermudah identifikasi teknisi di lokasi.</p>

        <form action="{{ route('pengaduan.store.public') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Pelapor <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor', auth()->user()?->name) }}" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('nama_pelapor') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nomor Kontak / WA <span class="text-red-500">*</span></label>
                    <input type="text" name="kontak_pelapor" value="{{ old('kontak_pelapor', auth()->user()?->no_hp) }}" placeholder="Contoh: 08123456789" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('kontak_pelapor') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Asal Instansi / OPD</label>
                    <input type="text" name="instansi_pelapor" value="{{ old('instansi_pelapor', auth()->user()?->instansi_opd) }}" placeholder="Contoh: Kantor Kecamatan X" class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('instansi_pelapor') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori Masalah <span class="text-red-500">*</span></label>
                    <select name="kategori_id" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Kategori Kendala --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Kendala <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Sambungan FO Putus di Ruang Pelayanan" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('judul') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Lokasi Detail Kejadian <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung B Lantai 2 Ruang Server" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('lokasi') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi Kerusakan <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan secara rinci kronologi kendala atau kode error..." required class="w-full text-sm border rounded-lg p-3 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Upload Foto Bukti Awal -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Lampiran Foto Kerusakan / Indikator (Opsional)</label>
                <input type="file" name="foto_bukti" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <span class="text-xs text-slate-400 mt-1 block">Format: JPG, PNG, WEBP. Maksimal 2MB.</span>
                @error('foto_bukti') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow">
                <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim Laporan Pengaduan
            </button>
        </form>
    </div>
</div>
@endsection