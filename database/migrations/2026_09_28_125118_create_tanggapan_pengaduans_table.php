<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanggapan_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('restrict');
            $table->text('catatan');
            $table->string('foto_tindak_lanjut', 255)->nullable(); // Foto bukti pengerjaan/perbaikan oleh petugas lapangan
            $table->enum('status_sebelumnya', ['menunggu', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])->nullable();
            $table->enum('status_sesudahnya', ['menunggu', 'diverifikasi', 'diproses', 'selesai', 'ditolak']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanggapan_pengaduan');
    }
};