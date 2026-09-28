@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_heading', 'Kelola Pengguna Sistem')

@section('content')
<div class="bg-white rounded-xl border shadow-sm overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h3 class="font-bold text-sm text-slate-700">Daftar Akun Pengguna & Petugas</h3>
        <a href="{{ route('superadmin.users.create') }}" class="bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-700">
            + Tambah Pengguna
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b text-slate-500 uppercase font-semibold">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Instansi OPD</th>
                    <th class="p-3">Peran (Role)</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y text-slate-700">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-bold">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">{{ $user->instansi_opd ?? '-' }}</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-bold uppercase bg-slate-100 border">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('superadmin.users.edit', $user) }}" class="text-blue-600 font-semibold hover:underline">Edit</a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 font-semibold hover:underline">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">
        {{ $users->links() }}
    </div>
</div>
@endsection