@extends('layouts.public')

@section('title', 'Login Petugas - Kominfo')

@section('content')
<div class="max-w-md mx-auto my-14 px-4">
    <div class="bg-white p-8 rounded-xl border shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 mb-1 text-center">Masuk ke Sistem</h2>
        <p class="text-xs text-slate-500 mb-6 text-center">Akses panel verifikator, administrator, dan perwakilan OPD.</p>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Kata Sandi</label>
                <input type="password" name="password" required class="w-full text-sm border rounded-lg px-3 py-2 border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded text-blue-600 border-slate-300">
                    <span class="ml-2 text-slate-600">Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-lg hover:bg-blue-700 transition">
                Masuk
            </button>
        </form>

        <p class="text-xs text-center text-slate-500 mt-6">
            Belum punya akun perwakilan OPD? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection