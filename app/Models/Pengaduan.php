<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'kode_tiket',
        'user_id',
        'nama_pelapor',
        'kontak_pelapor',
        'instansi_pelapor',
        'kategori_id',
        'judul',
        'lokasi',
        'deskripsi',
        'foto_bukti',
        'prioritas',
        'status',
        'petugas_id',
    ];

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function tanggapan(): HasMany
    {
        return $this->hasMany(TanggapanPengaduan::class, 'pengaduan_id')->latest();
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopePrioritas(Builder $query, ?string $prioritas): Builder
    {
        return $prioritas ? $query->where('prioritas', $prioritas) : $query;
    }

    public function scopeCari(Builder $query, ?string $kata): Builder
    {
        return $kata ? $query->where(function (Builder $q) use ($kata) {
            $q->where('kode_tiket', 'like', "%{$kata}%")
              ->orWhere('judul', 'like', "%{$kata}%")
              ->orWhere('nama_pelapor', 'like', "%{$kata}%")
              ->orWhere('instansi_pelapor', 'like', "%{$kata}%");
        }) : $query;
    }
}