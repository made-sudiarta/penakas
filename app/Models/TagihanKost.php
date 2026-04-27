<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TagihanKost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'penghuni_id',
        'kamar_kost_id',
        'bulan',
        'tahun',
        'tanggal_jatuh_tempo',
        'total_tagihan',
        'total_dibayar',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(Penghuni::class);
    }

    public function kamarKost(): BelongsTo
    {
        return $this->belongsTo(KamarKost::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TagihanKostDetail::class);
    }

    public function pembayaranKosts(): HasMany
    {
        return $this->hasMany(PembayaranKost::class);
    }

    public function updateStatusPembayaran(): void
    {
        $totalDibayar = $this->pembayaranKosts()->sum('jumlah_bayar');

        $status = 'belum_lunas';

        if ($totalDibayar <= 0) {
            $status = 'belum_lunas';
        } elseif ($totalDibayar < $this->total_tagihan) {
            $status = 'sebagian';
        } else {
            $status = 'lunas';
        }

        $this->update([
            'total_dibayar' => $totalDibayar,
            'status' => $status,
        ]);
    }
}