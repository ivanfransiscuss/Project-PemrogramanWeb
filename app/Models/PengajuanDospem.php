<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanDospem extends Model
{
    protected $table = 'pengajuan_dospem';
    protected $primaryKey = 'id_pengajuan';
    public $timestamps = true;

    protected $fillable = [
        'kelompok_id',
        'dosen_id',
        'judul_proposal',
        'abstract_singkat',
        'status',
        'catatan_dosen',
    ];

    protected function casts(): array
    {
        return [
            'kelompok_id' => 'integer',
            'dosen_id' => 'integer',
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
