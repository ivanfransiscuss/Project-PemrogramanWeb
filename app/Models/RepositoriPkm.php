<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepositoriPkm extends Model
{
    protected $table = 'repositori_pkm';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'kategori',
        'skema_pkm',
        'tahun',
        'deskripsi',
        'file_path',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'uploaded_by' => 'integer',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
