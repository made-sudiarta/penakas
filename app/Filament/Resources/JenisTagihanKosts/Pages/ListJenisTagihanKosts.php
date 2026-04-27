<?php

namespace App\Filament\Resources\JenisTagihanKosts\Pages;

use App\Filament\Resources\JenisTagihanKosts\JenisTagihanKostResource;
use App\Filament\Resources\JenisTagihanKosts\Widgets\JenisTagihanKostStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisTagihanKosts extends ListRecords
{
    protected static string $resource = JenisTagihanKostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tagihan Baru')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            JenisTagihanKostStats::class,
        ];
    }
}