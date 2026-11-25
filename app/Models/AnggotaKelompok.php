<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaKelompok extends Model
{
    protected $table = 'anggota_kelompok';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kelompok_id',
        'user_id',
        'peran_anggota',
        'status_bergabung',
    ];

    protected function casts(): array
    {
        return [
            'kelompok_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
