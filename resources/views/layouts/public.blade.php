<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Layanan Pengaduan Kominfo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">
    <!-- Navbar Publik -->
    <header class="bg-white border-b sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center space-x-3">
                <span class="bg-blue-600 text-white p-2 rounded-lg text-lg font-bold">
                    <i class="fa-solid fa-network-wired"></i>
                </span>
                <div>
                    <span class="font-extrabold text-slate-900 text-lg block leading-none">HELP-DESK</span>
                    <span class="text-xs text-slate-500 font-medium">DISKOMINFO</span>
                </div>
            </a>
            <nav class="flex items-center space-x-4 text-sm font-medium">
                <a href="{{ route('landing') }}" class="hover:text-blue-600 transition">Buat Aduan</a>
                <a href="{{ route('pengaduan.tracking') }}" class="hover:text-blue-600 transition flex items-center gap-1.5 text-blue-700 bg-blue-50 px-3 py-1.5 rounded-md">
                    <i class="fa-solid fa-magnifying-glass"></i> Lacak Tiket
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-slate-800 transition">
                        Panel Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-900 px-3 py-1.5">
                        Masuk Petugas
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-400 py-6 border-t text-center text-xs">
        <p>&copy; 2026 Dinas Komunikasi dan Informatika. Sistem Penanganan Kendala Layanan Jaringan & SPBE.</p>
    </footer>
</body>
</html>