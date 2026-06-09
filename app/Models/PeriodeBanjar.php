<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeBanjar extends Model
{
    use SoftDeletes;
    protected $table = 'periode_banjars';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
        'is_closed',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
        'is_closed' => 'boolean',
    ];

    
    protected static function booted(): void
    {
        static::saving(function ($model) {

            if ($model->is_active) {

                static::query()
                    ->whereKeyNot($model->id)
                    ->update([
                        'is_active' => false,
                    ]);
            }
        });
    }

    public function transaksiBanjars(): HasMany
    {
        return $this->hasMany(
            \App\Models\TransaksiBanjar::class,
            'periode_banjar_id'
        );
    }
}
