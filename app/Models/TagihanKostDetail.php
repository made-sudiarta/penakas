<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagihanKostDetail extends Model
{
    protected $fillable = [
        'tagihan_kost_id',
        'jenis_tagihan_kost_id',
        'nama_tagihan',
        'nominal',
    ];

    public function tagihanKost(): BelongsTo
    {
        return $this->belongsTo(TagihanKost::class);
    }

    public function jenisTagihanKost(): BelongsTo
    {
        return $this->belongsTo(JenisTagihanKost::class);
    }
}