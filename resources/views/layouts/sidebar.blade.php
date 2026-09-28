<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 min-h-screen">
    <div class="p-5">
        <div class="flex items-center space-x-3 mb-8">
            <div class="bg-blue-600 text-white p-2 rounded-lg font-bold">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <h1 class="text-white font-bold leading-none">PANEL HELPDESK</h1>
                <span class="text-xs text-slate-400">Kominfo Operasional</span>
            </div>
        </div>

        <nav class="space-y-1.5 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-4 text-center"></i> Ringkasan Sistem
            </a>

            {{-- 1. Sidebar Untuk Semua User / OPD --}}
            <div class="pt-4 pb-1 text-xs uppercase text-slate-500 font-semibold tracking-wider px-3">Layanan Aduan</div>
            <a href="{{ route('user.pengaduan.riwayat') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('user.pengaduan.riwayat') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i> Aduan Saya
            </a>

            {{-- 2. Sidebar Admin & Superadmin --}}
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <div class="pt-4 pb-1 text-xs uppercase text-slate-500 font-semibold tracking-wider px-3">Teknis Lapangan</div>
                <a href="{{ route('admin.pengaduan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.pengaduan.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-list-check w-4 text-center"></i> Verifikasi & ACC Tiket
                </a>
            @endif

            {{-- 3. Sidebar Superadmin Saja --}}
            @if(auth()->check() && auth()->user()->role === 'superadmin')
                <div class="pt-4 pb-1 text-xs uppercase text-slate-500 font-semibold tracking-wider px-3">Master Administrasi</div>
                <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('superadmin.users.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-users w-4 text-center"></i> Kelola Pengguna
                </a>
                <a href="{{ route('superadmin.kategori.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('superadmin.kategori.*') ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-folder-tree w-4 text-center"></i> Kategori Layanan
                </a>
            @endif
        </nav>
    </div>

    <div class="p-4 border-t border-slate-800">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 text-xs text-slate-400 hover:text-white">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Publik
        </a>
    </div>
</aside>