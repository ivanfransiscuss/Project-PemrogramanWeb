<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }

    public function profilMahasiswa(): HasOne
    {
        return $this->hasOne(ProfilMahasiswa::class, 'user_id', 'id');
    }

    public function profilDosen(): HasOne
    {
        return $this->hasOne(ProfilDosen::class, 'user_id', 'id');
    }

    public function jadwalDosen(): HasMany
    {
        return $this->hasMany(JadwalDosen::class, 'dosen_id', 'id');
    }

    public function kelompokDipimpin(): HasMany
    {
        return $this->hasMany(Kelompok::class, 'ketua_id', 'id');
    }

    public function kelompokDibimbing(): HasMany
    {
        return $this->hasMany(Kelompok::class, 'dosen_pembimbing_id', 'id');
    }

    public function keanggotaan(): HasMany
    {
        return $this->hasMany(AnggotaKelompok::class, 'user_id', 'id');
    }

    public function kelompok(): BelongsToMany
    {
        return $this->belongsToMany(Kelompok::class, 'anggota_kelompok', 'user_id', 'kelompok_id')
            ->withPivot('peran_anggota', 'status_bergabung')
            ->withTimestamps();
    }

    public function pengajuanDospem(): HasMany
    {
        return $this->hasMany(PengajuanDospem::class, 'dosen_id', 'id');
    }

    public function repositoriPkm(): HasMany
    {
        return $this->hasMany(RepositoriPkm::class, 'uploaded_by', 'id');
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class, 'dosen_id', 'id');
    }
}