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
}