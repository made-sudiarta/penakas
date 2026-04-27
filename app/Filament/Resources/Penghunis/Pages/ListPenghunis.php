<?php

namespace App\Filament\Resources\Penghunis\Pages;

use App\Filament\Resources\Penghunis\PenghuniResource;
use App\Filament\Resources\Penghunis\Widgets\PenghuniStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenghunis extends ListRecords
{
    protected static string $resource = PenghuniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Penghuni Baru')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PenghuniStats::class,
        ];
    }
}