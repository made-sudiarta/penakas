<?php

namespace App\Filament\Resources\KamarKosts\Pages;

use App\Filament\Resources\KamarKosts\KamarKostResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewKamarKost extends ViewRecord
{
    protected static string $resource = KamarKostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
