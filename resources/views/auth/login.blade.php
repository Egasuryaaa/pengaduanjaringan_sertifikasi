@extends('layouts.public')

@section('title', 'Masuk Petugas - Kominfo')

@section('content')
<div class="max-w-md mx-auto my-14 px-4">
    <div class="bg-white p-8 rounded-xl border shadow-sm">
        <div class="text-center mb-6">
            <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded font-bold uppercase tracking-wider inline-block mb-2">Panel Internal</span>
            <h2 class="text-xl font-bold text-slate-800">Masuk ke Sistem</h2>
            <p class="text-xs text-slate-500 mt-1">Khusus petugas teknis dan administrator Kominfo.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Email Dinas</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Kata Sandi</label>
                <input type="password" name="password" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-blue-600 border-slate-300">
                    <span class="ml-2 text-slate-600">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-lg hover:bg-blue-700 transition">
                Masuk ke Panel
            </button>
        </form>

        <div class="mt-6 pt-4 border-t text-center text-xs text-slate-400">
            Kendala akses akun? Hubungi Super Administrator Dinas.
        </div>
    </div>
</div>
@endsection