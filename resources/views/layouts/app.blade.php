<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Kontrol Kominfo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex">
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
        <header class="bg-white border-b h-16 flex items-center justify-between px-6 shrink-0">
            <h2 class="font-bold text-slate-700 text-lg">@yield('page_heading', 'Dashboard')</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-slate-600">
                    {{ auth()->user()->name }} 
                    <span class="text-xs bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full ml-1 font-semibold uppercase">
                        {{ auth()->user()->role }}
                    </span>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-semibold">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </header>

        <main class="p-6 overflow-y-auto flex-1">
            @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm flex items-center justify-between">
                    <span><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg text-sm flex items-center justify-between">
                    <span><i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>