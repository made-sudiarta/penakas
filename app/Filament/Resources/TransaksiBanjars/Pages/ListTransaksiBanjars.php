<?php

namespace App\Filament\Resources\TransaksiBanjars\Pages;

use App\Filament\Resources\TransaksiBanjars\TransaksiBanjarResource;
use App\Filament\Resources\TransaksiBanjars\Widgets\TransaksiBanjarStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransaksiBanjars extends ListRecords
{
    protected static string $resource = TransaksiBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Transaksi Baru')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TransaksiBanjarStats::class,
        ];
    }
}