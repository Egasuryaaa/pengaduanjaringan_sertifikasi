<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'no_hp',
        'instansi_opd',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'user_id');
    }

    public function tugasPengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'petugas_id');
    }

    public function tanggapan(): HasMany
    {
        return $this->hasMany(TanggapanPengaduan::class, 'petugas_id');
    }
}