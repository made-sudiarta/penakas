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
}