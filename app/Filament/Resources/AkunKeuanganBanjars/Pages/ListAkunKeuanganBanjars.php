<?php

namespace App\Filament\Resources\AkunKeuanganBanjars\Pages;

use App\Filament\Resources\AkunKeuanganBanjars\AkunKeuanganBanjarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAkunKeuanganBanjars extends ListRecords
{
    protected static string $resource = AkunKeuanganBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
