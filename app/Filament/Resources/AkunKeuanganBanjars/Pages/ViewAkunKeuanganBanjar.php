<?php

namespace App\Filament\Resources\AkunKeuanganBanjars\Pages;

use App\Filament\Resources\AkunKeuanganBanjars\AkunKeuanganBanjarResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAkunKeuanganBanjar extends ViewRecord
{
    protected static string $resource = AkunKeuanganBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
