@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page_heading', 'Tambah Pengguna Baru')

@section('content')
    <div class="max-w-xl bg-white p-6 rounded-xl border shadow-sm">
        <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border rounded px-3 py-2 border-slate-300">
            </div>
            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border rounded px-3 py-2 border-slate-300">
            </div>
            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                    class="w-full border rounded px-3 py-2 border-slate-300">
            </div>
            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Instansi OPD</label>
                <input type="text" name="instansi_opd" value="{{ old('instansi_opd') }}"
                    class="w-full border rounded px-3 py-2 border-slate-300">
            </div>
            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Peran (Role)</label>
                <select name="role" required class="w-full border rounded px-3 py-2 border-slate-300">
                    <option value="admin">Admin (Petugas Verifikasi / Lapangan)</option>
                    <option value="superadmin">Superadmin (Administrator Sistem)</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Kata Sandi</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2 border-slate-300">
            </div>
            <div>
                <label class="block font-bold text-slate-600 uppercase mb-1">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border rounded px-3 py-2 border-slate-300">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" class="bg-blue-600 text-white font-bold px-4 py-2 rounded hover:bg-blue-700">Simpan
                    User</button>
                <a href="{{ route('superadmin.users.index') }}"
                    class="bg-slate-200 text-slate-600 px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection