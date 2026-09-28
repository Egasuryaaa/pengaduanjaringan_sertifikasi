<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TanggapanPengaduan extends Model
{
    use HasFactory;

    protected $table = 'tanggapan_pengaduan';

    protected $fillable = [
        'pengaduan_id',
        'petugas_id',
        'catatan',
        'foto_tindak_lanjut',
        'status_sebelumnya',
        'status_sesudahnya',
    ];

    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}