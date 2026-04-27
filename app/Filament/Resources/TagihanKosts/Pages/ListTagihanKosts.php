<?php

namespace App\Filament\Resources\TagihanKosts\Pages;

use App\Filament\Resources\TagihanKosts\TagihanKostResource;
use App\Filament\Resources\TagihanKosts\Widgets\TagihanKostStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTagihanKosts extends ListRecords
{
    protected static string $resource = TagihanKostResource::class;

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
            TagihanKostStats::class,
        ];
    }
}