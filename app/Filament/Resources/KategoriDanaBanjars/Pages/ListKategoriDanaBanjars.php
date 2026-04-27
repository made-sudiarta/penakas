<?php

namespace App\Filament\Resources\KategoriDanaBanjars\Pages;

use App\Filament\Resources\KategoriDanaBanjars\KategoriDanaBanjarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKategoriDanaBanjars extends ListRecords
{
    protected static string $resource = KategoriDanaBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Kategori Baru')
                ->icon('heroicon-o-plus'),
        ];
    }
}