<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KamarKost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama_kamar',
        'nomor_kamar',
        'harga_default',
        'status',
        'keterangan',
    ];

    public function penghunis(): HasMany
    {
        return $this->hasMany(Penghuni::class);
    }

    public function tagihanKosts(): HasMany
    {
        return $this->hasMany(TagihanKost::class);
    }
}