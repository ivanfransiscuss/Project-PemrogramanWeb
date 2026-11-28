<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Postingan extends Model
{
    protected $table = 'postingan';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'kelompok_id',
        'tipe',
        'skema_pkm',
        'isi',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'kelompok_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }

    public function balasan(): HasMany
    {
        return $this->hasMany(BalasanPostingan::class, 'postingan_id', 'id');
    }
}
