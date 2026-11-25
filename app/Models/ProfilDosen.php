<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilDosen extends Model
{
    protected $table = 'profil_dosen';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nidn',
        'bidang_keahlian',
        'kuota_bimbingan',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'kuota_bimbingan' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
        public function kelompokDipimpin(): HasMany
    {
        return $this->hasMany(Kelompok::class, 'ketua_id', 'id');
    }

    public function kelompokDibimbing(): HasMany
    {
        return $this->hasMany(Kelompok::class, 'dosen_pembimbing_id', 'id');
    }

    public function keanggotaan(): HasMany
    {
        return $this->hasMany(AnggotaKelompok::class, 'user_id', 'id');
    }

    public function kelompok(): BelongsToMany
    {
        return $this->belongsToMany(Kelompok::class, 'anggota_kelompok', 'user_id', 'kelompok_id')
            ->withPivot('peran_anggota', 'status_bergabung')
            ->withTimestamps();
    }
}