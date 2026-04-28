<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AppSetting extends Model
{
    protected $fillable = [
        'app_name',
        'owner_name',
        'phone',
        'address',
        'logo',
        'description',
    ];

    public static function getSetting(): self
    {
        return self::query()->firstOrCreate([
            'id' => 1,
        ], [
            'app_name' => 'PenaKas',
        ]);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo) {
            return null;
        }

        return Storage::disk('public')->url($this->logo);
    }
}