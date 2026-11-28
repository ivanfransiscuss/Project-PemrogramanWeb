<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingBimbingan extends Model
{
    protected $table = 'booking_bimbingan';
    protected $primaryKey = 'id_bimbingan';
    public $timestamps = true;

    protected $fillable = [
        'jadwal_id',
        'kelompok_id',
        'topik_bimbingan',
        'status_booking',
    ];

    protected function casts(): array
    {
        return [
            'jadwal_id' => 'integer',
            'kelompok_id' => 'integer',
        ];
    }

    // Relasi ke Jadwal
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalDosen::class, 'jadwal_id', 'id_jadwal');
    }

    // Relasi ke Kelompok
    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }
}