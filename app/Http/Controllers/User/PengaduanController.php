<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    public function index()
    {
        $kategoriList = KategoriPengaduan::orderBy('nama_kategori')->get();
        return view('landing.index', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:100',
            'kontak_pelapor' => 'required|string|max:50',
            'instansi_pelapor' => 'nullable|string|max:150',
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'judul' => 'required|string|max:150',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pathBukti = null;
        if ($request->hasFile('foto_bukti')) {
            $pathBukti = $request->file('foto_bukti')->store('pengaduan/bukti', 'public');
        }

        $kodeTiket = 'TKT-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        Pengaduan::create([
            'kode_tiket' => $kodeTiket,
            'nama_pelapor' => $validated['nama_pelapor'],
            'kontak_pelapor' => $validated['kontak_pelapor'],
            'instansi_pelapor' => $validated['instansi_pelapor'],
            'kategori_id' => $validated['kategori_id'],
            'judul' => $validated['judul'],
            'lokasi' => $validated['lokasi'],
            'deskripsi' => $validated['deskripsi'],
            'foto_bukti' => $pathBukti,
            'status' => 'menunggu',
            'prioritas' => 'sedang',
        ]);

        return redirect()->route('pengaduan.tracking', ['tiket' => $kodeTiket])
            ->with('success', 'Laporan aduan Anda telah berhasil didaftarkan ke sistem.')
            ->with('tiket_baru', $kodeTiket);
    }

    public function tracking(Request $request)
    {
        $tiket = $request->query('tiket') ?? $request->input('tiket');
        $pengaduan = null;

        if ($tiket) {
            $pengaduan = Pengaduan::with(['kategori', 'petugas', 'tanggapan.petugas'])
                ->where('kode_tiket', trim($tiket))
                ->first();
        }

        return view('landing.tracking', compact('pengaduan', 'tiket'));
    }
}