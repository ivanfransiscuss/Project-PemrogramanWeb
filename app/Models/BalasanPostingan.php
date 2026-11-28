<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalasanPostingan extends Model
{
    protected $table = 'balasan_postingan';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'postingan_id',
        'user_id',
        'isi',
    ];

    protected function casts(): array
    {
        return [
            'postingan_id' => 'integer',
            'user_id' => 'integer',
        ];
    }

    public function postingan(): BelongsTo
    {
        return $this->belongsTo(Postingan::class, 'postingan_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
