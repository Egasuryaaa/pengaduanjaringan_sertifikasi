<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Super Administrator
        $superadmin = User::create([
            'name'         => 'Super Administrator Kominfo',
            'email'        => 'superadmin@kominfo.go.id',
            'no_hp'        => '081234567890',
            'instansi_opd' => 'Dinas Kominfo',
            'password'     => Hash::make('password123'),
            'role'         => 'superadmin',
        ]);

        // 2. Akun Admin Verifikator & Petugas Lapangan
        $admin = User::create([
            'name'         => 'Admin Teknis Jaringan',
            'email'        => 'admin@kominfo.go.id',
            'no_hp'        => '081234567891',
            'instansi_opd' => 'Bidang Informatika & Jaringan',
            'password'     => Hash::make('password123'),
            'role'         => 'admin',
        ]);

        // 3. Kategori Layanan Kominfo
        $kategoriFO = KategoriPengaduan::create([
            'nama_kategori' => 'Jaringan Fiber Optik & Internet',
            'slug'          => 'jaringan-fiber-optik-internet',
            'deskripsi'     => 'Gangguan koneksi internet kantor, kabel FO putus, atau drop link.',
        ]);

        $kategoriServer = KategoriPengaduan::create([
            'nama_kategori' => 'Server & Aplikasi SPBE',
            'slug'          => 'server-aplikasi-spbe',
            'deskripsi'     => 'Layanan website pemda down, server database error, aplikasi tidak bisa diakses.',
        ]);

        // 4. Dummy Pengaduan Awal
        Pengaduan::create([
            'kode_tiket'       => 'TKT-' . date('Ymd') . '-INIT1',
            'nama_pelapor'     => 'Budi Santoso',
            'kontak_pelapor'   => '081298765432',
            'instansi_pelapor' => 'Kantor Kecamatan Wonosari',
            'kategori_id'      => $kategoriFO->id,
            'judul'            => 'Kabel Fiber Optik Terputus di Ruang Pelayanan',
            'lokasi'           => 'Gedung A Lantai 1',
            'deskripsi'        => 'Lampu indikator router PON merah mati sejak pukul 08:30 WIB.',
            'status'           => 'menunggu',
            'prioritas'        => 'tinggi',
        ]);
    }
}