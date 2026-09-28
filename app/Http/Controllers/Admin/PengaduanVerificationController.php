<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use App\Models\TanggapanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengaduanVerificationController extends Controller
{
    /**
     * Menampilkan daftar tiket aduan dengan filter dan eager loading anti N+1.
     */
    public function index(Request $request)
    {
        $kategoriList = KategoriPengaduan::all();

        $pengaduan = Pengaduan::with(['kategori', 'petugas', 'pelapor'])
            ->cari($request->query('q'))
            ->status($request->query('status'))
            ->prioritas($request->query('prioritas'))
            ->when($request->query('kategori_id'), function ($q, $katId) {
                return $q->where('kategori_id', $katId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengaduan.index', compact('pengaduan', 'kategoriList'));
    }

    /**
     * Detail pengaduan lengkap dengan foto bukti awal dan riwayat penanganan.
     */
    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['kategori', 'pelapor', 'petugas', 'tanggapan.petugas']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Verifikasi, ACC / Tolak, ubah prioritas, dan unggah foto penanganan teknis.
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status'             => 'required|in:diverifikasi,diproses,selesai,ditolak',
            'prioritas'          => 'required|in:rendah,sedang,tinggi,darurat',
            'catatan'            => 'required|string',
            'foto_tindak_lanjut' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pathTindakLanjut = null;
        if ($request->hasFile('foto_tindak_lanjut')) {
            $pathTindakLanjut = $request->file('foto_tindak_lanjut')->store('pengaduan/tindak_lanjut', 'public');
        }

        DB::transaction(function () use ($pengaduan, $validated, $pathTindakLanjut) {
            $statusLama = $pengaduan->status;

            // Update status tiket
            $pengaduan->update([
                'status'     => $validated['status'],
                'prioritas'  => $validated['prioritas'],
                'petugas_id' => auth()->id(),
            ]);

            // Buat entri tanggapan & histori audit trail
            TanggapanPengaduan::create([
                'pengaduan_id'       => $pengaduan->id,
                'petugas_id'         => auth()->id(),
                'catatan'            => $validated['catatan'],
                'foto_tindak_lanjut' => $pathTindakLanjut,
                'status_sebelumnya'  => $statusLama,
                'status_sesudahnya'  => $validated['status'],
            ]);
        });

        return back()->with('success', 'Status pengaduan dan log penanganan teknis berhasil diperbarui.');
    }

    /**
     * Hapus tiket beserta file fisik gambar dari storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        DB::transaction(function () use ($pengaduan) {
            if ($pengaduan->foto_bukti && Storage::disk('public')->exists($pengaduan->foto_bukti)) {
                Storage::disk('public')->delete($pengaduan->foto_bukti);
            }

            foreach ($pengaduan->tanggapan as $tanggapan) {
                if ($tanggapan->foto_tindak_lanjut && Storage::disk('public')->exists($tanggapan->foto_tindak_lanjut)) {
                    Storage::disk('public')->delete($tanggapan->foto_tindak_lanjut);
                }
            }

            $pengaduan->delete();
        });

        return redirect()->route('admin.pengaduan.index')->with('success', 'Data tiket pengaduan berhasil dihapus.');
    }
}