<?php

namespace App\Filament\Resources\KamarKosts\Pages;

use App\Filament\Resources\KamarKosts\KamarKostResource;
use App\Filament\Resources\KamarKosts\Widgets\KamarKostStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKamarKosts extends ListRecords
{
    protected static string $resource = KamarKostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Kamar Baru')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            KamarKostStats::class,
        ];
    }
}