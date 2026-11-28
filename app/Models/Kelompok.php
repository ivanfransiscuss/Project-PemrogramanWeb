<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelompok extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama_kelompok',
        'skema_pkm',
        'deskripsi_kebutuhan',
        'ketua_id',
        'dosen_pembimbing_id',
        'status_rekrutmen',
    ];

    protected function casts(): array
    {
        return [
            'ketua_id' => 'integer',
            'dosen_pembimbing_id' => 'integer',
        ];
    }

    public function ketua(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ketua_id', 'id');
    }

    public function dosenPembimbing(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id', 'id');
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaKelompok::class, 'kelompok_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'anggota_kelompok', 'kelompok_id', 'user_id')
            ->withPivot('peran_anggota', 'status_bergabung')
            ->withTimestamps();
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'kelompok_id', 'id');
    }

    public function postingan(): HasMany
    {
        return $this->hasMany(Postingan::class, 'kelompok_id', 'id');
    }
}
