<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
    /**
     * Halaman Landing Page Form Pengaduan Publik.
     */
    public function index()
    {
        $kategoriList = KategoriPengaduan::orderBy('nama_kategori')->get();
        return view('landing.index', compact('kategoriList'));
    }

    /**
     * Simpan pengaduan baru dari formulir publik / user OPD.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor'     => 'required|string|max:100',
            'kontak_pelapor'   => 'required|string|max:50',
            'instansi_pelapor' => 'nullable|string|max:150',
            'kategori_id'      => 'required|exists:kategori_pengaduan,id',
            'judul'            => 'required|string|max:150',
            'lokasi'           => 'required|string|max:255',
            'deskripsi'        => 'required|string',
            'foto_bukti'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pathBukti = null;
        if ($request->hasFile('foto_bukti')) {
            $pathBukti = $request->file('foto_bukti')->store('pengaduan/bukti', 'public');
        }

        // Generate Kode Tiket unik: TKT-20260928-XXXXX
        $kodeTiket = 'TKT-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $pengaduan = Pengaduan::create([
            'kode_tiket'       => $kodeTiket,
            'user_id'          => auth()->id(), // null jika pelapor publik/tamu
            'nama_pelapor'     => $validated['nama_pelapor'],
            'kontak_pelapor'   => $validated['kontak_pelapor'],
            'instansi_pelapor' => $validated['instansi_pelapor'] ?? (auth()->user()?->instansi_opd),
            'kategori_id'      => $validated['kategori_id'],
            'judul'            => $validated['judul'],
            'lokasi'           => $validated['lokasi'],
            'deskripsi'        => $validated['deskripsi'],
            'foto_bukti'       => $pathBukti,
            'status'           => 'menunggu',
            'prioritas'        => 'sedang',
        ]);

        return redirect()->route('pengaduan.tracking', ['tiket' => $kodeTiket])
            ->with('success', 'Laporan Anda berhasil dikirim! Silakan simpan ID Tiket ini untuk melacak status aduan.');
    }

    /**
     * Pelacakan status tiket oleh user umum tanpa perlu login.
     */
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

    /**
     * Riwayat tiket aduan bagi user yang memiliki akun & login.
     */
    public function riwayat(Request $request)
    {
        $pengaduanSaya = Pengaduan::with(['kategori', 'petugas'])
            ->where('user_id', auth()->id())
            ->cari($request->query('q'))
            ->status($request->query('status'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.pengaduan.riwayat', compact('pengaduanSaya'));
    }

    /**
     * Batalkan aduan jika status masih 'menunggu'.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== auth()->id() || $pengaduan->status !== 'menunggu') {
            return back()->with('error', 'Aduan ini tidak dapat dibatalkan.');
        }

        if ($pengaduan->foto_bukti && Storage::disk('public')->exists($pengaduan->foto_bukti)) {
            Storage::disk('public')->delete($pengaduan->foto_bukti);
        }

        $pengaduan->delete();

        return back()->with('success', 'Laporan aduan berhasil dibatalkan.');
    }
}