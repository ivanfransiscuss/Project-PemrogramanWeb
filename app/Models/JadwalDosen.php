<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalDosen extends Model
{
    protected $table = 'jadwal_dosen';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = true;

    protected $fillable = [
        'dosen_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'metode',
        'lokasi_atau_link',
        'status_slot',
    ];

    protected function casts(): array
    {
        return [
            'dosen_id' => 'integer',
            'tanggal' => 'date',
        ];
    }

    // Relasi ke dosen
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id', 'id');
    }

    // Relasi ke booking
    public function bookings(): HasMany
    {
        return $this->hasMany(BookingBimbingan::class, 'jadwal_id', 'id_jadwal');
    }
}