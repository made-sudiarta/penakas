<?php

namespace App\Filament\Resources\PeriodeBanjars\Pages;

use App\Filament\Resources\PeriodeBanjars\PeriodeBanjarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPeriodeBanjars extends ListRecords
{
    protected static string $resource = PeriodeBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
