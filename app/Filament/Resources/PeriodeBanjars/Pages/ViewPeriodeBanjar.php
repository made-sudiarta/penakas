<?php

namespace App\Filament\Resources\PeriodeBanjars\Pages;

use App\Filament\Resources\PeriodeBanjars\PeriodeBanjarResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPeriodeBanjar extends ViewRecord
{
    protected static string $resource = PeriodeBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
