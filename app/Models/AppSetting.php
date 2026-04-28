<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
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

    // public static function getSetting(): self
    // {
    //     return self::query()->firstOrCreate([
    //         'id' => 1,
    //     ], [
    //         'app_name' => 'PenaKas',
    //     ]);
    // }
    public static function getSetting(): self
    {
        if (! Schema::hasTable('app_settings')) {
            return new self([
                'app_name' => 'PenaKas',
            ]);
        }

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