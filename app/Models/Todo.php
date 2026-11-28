<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    protected $table = 'todos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kelompok_id',
        'judul_tugas',
        'kategori',
        'is_selesai',
        'tenggat_waktu',
    ];

    protected function casts(): array
    {
        return [
            'kelompok_id' => 'integer',
            'is_selesai' => 'boolean',
            'tenggat_waktu' => 'date',
        ];
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }
}
