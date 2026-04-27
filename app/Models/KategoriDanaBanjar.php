<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriDanaBanjar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function transaksiBanjars(): HasMany
    {
        return $this->hasMany(TransaksiBanjar::class);
    }
}