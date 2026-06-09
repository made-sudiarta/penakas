<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiBanjar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_dana_banjar_id',
        'periode_banjar_id',
        'akun_keuangan_banjar_id',
        'tanggal',
        'tipe',
        'judul',
        'nominal',
        'keterangan',
        'foto_nota',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kategoriDanaBanjar(): BelongsTo
    {
        return $this->belongsTo(KategoriDanaBanjar::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function periode(): BelongsTo
    {
        return $this->belongsTo(
            PeriodeBanjar::class,
            'periode_banjar_id',
            'id'
        );
    }
    public function akun(): BelongsTo
    {
        return $this->belongsTo(
            AkunKeuanganBanjar::class,
            'akun_keuangan_banjar_id'
        );
    }
}