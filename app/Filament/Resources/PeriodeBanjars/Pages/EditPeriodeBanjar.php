<?php

namespace App\Filament\Resources\PeriodeBanjars\Pages;

use App\Filament\Resources\PeriodeBanjars\PeriodeBanjarResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPeriodeBanjar extends EditRecord
{
    protected static string $resource = PeriodeBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
