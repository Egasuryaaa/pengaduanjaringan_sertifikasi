<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriPengaduan::withCount('pengaduan')->latest()->paginate(10);
        return view('superadmin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('superadmin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_pengaduans,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['nama_kategori']);
        KategoriPengaduan::create($validated);

        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori pengaduan baru berhasil disimpan.');
    }

    public function edit(KategoriPengaduan $kategori)
    {
        return view('superadmin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriPengaduan $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategori_pengaduan')->ignore($kategori->id)],
            'deskripsi'     => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['nama_kategori']);
        $kategori->update($validated);

        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori pengaduan berhasil diperbarui.');
    }

    public function destroy(KategoriPengaduan $kategori)
    {
        if ($kategori->pengaduan()->exists()) {
            return back()->with('error', 'Kategori ini tidak dapat dihapus karena masih dipakai oleh tiket aduan aktif.');
        }

        $kategori->delete();
        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori pengaduan berhasil dihapus.');
    }
}