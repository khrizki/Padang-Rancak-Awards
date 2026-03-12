<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelurahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kecamatan_id',
        'nama',
        'kode',
    ];

    /**
     * Get the kecamatan that owns the kelurahan.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Get all RWs for the kelurahan.
     */
    public function rws(): HasMany
    {
        return $this->hasMany(RW::class);
    }

    /**
     * Get all RTs through RWs.
     */
    public function rts()
    {
        return $this->hasManyThrough(RT::class, RW::class);
    }
}
