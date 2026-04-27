<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranKost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tagihan_kost_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function tagihanKost(): BelongsTo
    {
        return $this->belongsTo(TagihanKost::class);
    }

    protected static function booted(): void
    {
        static::saved(function (PembayaranKost $pembayaranKost) {
            $pembayaranKost->tagihanKost?->updateStatusPembayaran();
        });

        static::deleted(function (PembayaranKost $pembayaranKost) {
            $pembayaranKost->tagihanKost?->updateStatusPembayaran();
        });
    }
}