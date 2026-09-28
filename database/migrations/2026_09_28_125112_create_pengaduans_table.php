<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket', 30)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama_pelapor', 100);
            $table->string('kontak_pelapor', 50);
            $table->string('instansi_pelapor', 150)->nullable();
            $table->foreignId('kategori_id')->constrained('kategori_pengaduan')->onDelete('restrict');
            $table->string('judul', 150);
            $table->string('lokasi', 255);
            $table->text('deskripsi');
            $table->string('foto_bukti', 255)->nullable(); // Lampiran foto kerusakan awal dari pelapor
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'darurat'])->default('sedang');
            $table->enum('status', ['menunggu', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};