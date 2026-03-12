<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RT extends Model
{
    use HasFactory;

    protected $table = 'rts';

    protected $fillable = [
        'rw_id',
        'nama',
        'nomor_rt',
        'status_terdaftar',
        'alamat',
        'jumlah_warga',
        'no_hp_ketua_rt',
    ];

    protected $casts = [
        'status_terdaftar' => 'string',
    ];

    /**
     * Get the RW that owns the RT.
     */
    public function rw(): BelongsTo
    {
        return $this->belongsTo(RW::class);
    }

    /**
     * Get the kelurahan through RW.
     */
    public function kelurahan()
    {
        return $this->through('rw')->kelurahan();
    }

    /**
     * Get the kecamatan through RW and kelurahan.
     */
    public function kecamatan()
    {
        return $this->through('rw')->through('kelurahan')->kecamatan();
    }

    /**
     * Check if RT is registered.
     */
    public function isTerdaftar(): bool
    {
        return $this->status_terdaftar === 'sudah';
    }

    /**
     * Scope to filter by registration status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status_terdaftar', $status === 'sudah');
    }

    public function getNamaLengkapAttribute()
    {
        return "RT {$this->nomor_rt} {$this->nama}";
    }

    public function getAlamatLengkapAttribute()
    {
        if (!$this->rw || !$this->rw->kelurahan || !$this->rw->kelurahan->kecamatan) {
            return $this->alamat ?? '';
        }

        $parts = array_filter([
            $this->nama,
            "RT {$this->nomor_rt}/RW {$this->rw->nomor_rw}",
            $this->rw->kelurahan->nama,
            $this->rw->kelurahan->kecamatan->nama,
            "Kota {$this->rw->kelurahan->kecamatan->kota}",
        ]);

        return implode(', ', $parts);
    }
}
