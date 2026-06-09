<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AkunKeuanganBanjar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'is_active',
    ];

    public function transaksiBanjars(): HasMany
    {
        return $this->hasMany(
            TransaksiBanjar::class,
            'akun_keuangan_banjar_id'
        );
    }
}