@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page_heading', 'Ubah Data Akun Pengguna')

@section('content')
    <div class="max-w-xl bg-white p-6 rounded-xl border shadow-sm">
        <form action="{{ route('superadmin.users.update', $user) }}" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Nomor Kontak / WhatsApp</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                    class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('no_hp') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Instansi / Unit OPD</label>
                <input type="text" name="instansi_opd" value="{{ old('instansi_opd', $user->instansi_opd) }}"
                    class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('instansi_opd') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Peran (Role)</label>
                <select name="role" required
                    class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500">
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin (Petugas
                        Verifikasi / Lapangan)</option>
                    <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin
                        (Administrator Sistem)</option>
                </select>
                @error('role') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="border-t pt-3 mt-3">
                <span class="text-slate-400 text-[11px] block mb-2 italic">* Kosongkan kolom kata sandi jika tidak berniat
                    mengubahnya.</span>

                <div class="space-y-3">
                    <div>
                        <label class="block font-bold text-slate-600 uppercase mb-1">Kata Sandi Baru</label>
                        <input type="password" name="password"
                            class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-slate-600 uppercase mb-1">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border rounded px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit"
                    class="bg-blue-600 text-white font-bold px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('superadmin.users.index') }}"
                    class="bg-slate-200 text-slate-600 px-4 py-2 rounded hover:bg-slate-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection