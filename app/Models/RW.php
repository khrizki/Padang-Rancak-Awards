<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RW extends Model
{
    use HasFactory;

    protected $table = 'rws';

    protected $fillable = [
        'kelurahan_id',
        'nama',
        'nomor_rw',
    ];

    /**
     * Get the kelurahan that owns the RW.
     */
    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }

    /**
     * Get the kecamatan through kelurahan.
     */
    public function kecamatan()
    {
        return $this->through('kelurahan')->kecamatan();
    }

    /**
     * Get all RTs for the RW.
     */
    public function rts(): HasMany
    {
        return $this->hasMany(RT::class);
    }

    public function getNamaLengkapAttribute()
    {
        return "RW {$this->nomor_rw} {$this->nama}";
    }
}
