<?php

namespace App\Filament\Resources\KategoriDanaBanjars\Pages;

use App\Filament\Resources\KategoriDanaBanjars\KategoriDanaBanjarResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditKategoriDanaBanjar extends EditRecord
{
    protected static string $resource = KategoriDanaBanjarResource::class;

    public function getTitle(): string
    {
        return 'Edit Kategori Dana';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus'),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}