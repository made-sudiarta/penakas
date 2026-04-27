<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penghuni extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kamar_kost_id',
        'nama',
        'no_hp',
        'alamat',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function kamarKost(): BelongsTo
    {
        return $this->belongsTo(KamarKost::class);
    }

    public function tagihanKosts(): HasMany
    {
        return $this->hasMany(TagihanKost::class);
    }
}