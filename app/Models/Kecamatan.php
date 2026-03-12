<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'kota',
    ];

    /**
     * Get all kelurahans for the kecamatan.
     */
    public function kelurahans(): HasMany
    {
        return $this->hasMany(Kelurahan::class);
    }

    /**
     * Get all RWs through kelurahans.
     */
    public function rws()
    {
        return $this->hasManyThrough(RW::class, Kelurahan::class);
    }

    /**
     * Get all RTs through kelurahans and RWs.
     */
    public function rts()
    {
        return $this->hasManyThrough(RT::class, [Kelurahan::class, RW::class]);
    }

    public function getNamaWithKodeAttribute()
    {
        return "{$this->nama} ({$this->kode})";
    }
}
