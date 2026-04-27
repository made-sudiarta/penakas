<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisTagihanKost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'nominal_default',
        'is_bulanan',
        'is_active',
    ];

    protected $casts = [
        'is_bulanan' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function tagihanKostDetails(): HasMany
    {
        return $this->hasMany(TagihanKostDetail::class);
    }
}