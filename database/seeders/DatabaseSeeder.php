<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Superadmin
        $superadmin = User::create([
            'name'         => 'Super Administrator Kominfo',
            'email'        => 'superadmin@kominfo.go.id',
            'no_hp'        => '081234567890',
            'instansi_opd' => 'Dinas Kominfo',
            'password'     => Hash::make('password123'),
            'role'         => 'superadmin',
        ]);

        // 2. Akun Admin Verifikator Lapangan
        $admin = User::create([
            'name'         => 'Admin Teknis Jaringan',
            'email'        => 'admin@kominfo.go.id',
            'no_hp'        => '081234567891',
            'instansi_opd' => 'Bidang Informatika & Jaringan',
            'password'     => Hash::make('password123'),
            'role'         => 'admin',
        ]);

        // 3. Akun User / OPD
        $userOpd = User::create([
            'name'         => 'Operator Kecamatan',
            'email'        => 'opd@kominfo.go.id',
            'no_hp'        => '081234567892',
            'instansi_opd' => 'Kantor Kecamatan Wonosari',
            'password'     => Hash::make('password123'),
            'role'         => 'user',
        ]);

        // 4. Data Master Kategori Layanan Kominfo
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

        $kategoriBlankspot = KategoriPengaduan::create([
            'nama_kategori' => 'Blankspot & Menara Telekomunikasi',
            'slug'          => 'blankspot-menara',
            'deskripsi'     => 'Laporan area tanpa sinyal seluler atau kerusakan fasilitas menara BTS.',
        ]);

        // 5. Contoh Aduan Awal
        Pengaduan::create([
            'kode_tiket'       => 'TKT-' . date('Ymd') . '-INIT1',
            'user_id'          => $userOpd->id,
            'nama_pelapor'     => 'Operator Kecamatan',
            'kontak_pelapor'   => '081234567892',
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