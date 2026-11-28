<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Logbook extends Model
{
    protected $table = 'logbooks';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kelompok_id',
        'dosen_id',
        'tanggal_bimbingan',
        'topik_pembahasan',
        'catatan_mahasiswa',
        'catatan_revisi_dosen',
        'file_revisi',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'kelompok_id' => 'integer',
            'dosen_id' => 'integer',
            'tanggal_bimbingan' => 'date',
        ];
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id', 'id');
    }
}
