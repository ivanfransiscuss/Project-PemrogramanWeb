<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilMahasiswa extends Model
{
    protected $table = 'profil_mahasiswa';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        'angkatan',
        'minat_bidang',
        'no_hp',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'angkatan' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}