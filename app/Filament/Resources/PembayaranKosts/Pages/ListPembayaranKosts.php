<?php

namespace App\Filament\Resources\PembayaranKosts\Pages;

use App\Filament\Resources\PembayaranKosts\PembayaranKostResource;
use App\Filament\Resources\PembayaranKosts\Widgets\PembayaranKostStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPembayaranKosts extends ListRecords
{
    protected static string $resource = PembayaranKostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Pembayaran Baru')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PembayaranKostStats::class,
        ];
    }
}