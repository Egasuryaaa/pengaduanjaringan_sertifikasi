<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pengaduan' => Pengaduan::count(),
            'menunggu'        => Pengaduan::where('status', 'menunggu')->count(),
            'diproses'        => Pengaduan::whereIn('status', ['diverifikasi', 'diproses'])->count(),
            'selesai'         => Pengaduan::where('status', 'selesai')->count(),
            'ditolak'         => Pengaduan::where('status', 'ditolak')->count(),
            'total_user'      => User::count(),
            'total_kategori'  => KategoriPengaduan::count(),
        ];

        $aduanTerbaru = Pengaduan::with(['kategori', 'pelapor'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'aduanTerbaru'));
    }
}