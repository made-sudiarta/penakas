<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PenaKasOverview;
use App\Models\AppSetting;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return 'Dashboard - ' . (AppSetting::getSetting()->app_name);
    }

    public function getWidgets(): array
    {
        return [
            PenaKasOverview::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 1,
        ];
    }
}