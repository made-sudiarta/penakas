<?php

namespace App\Filament\Resources\KategoriDanaBanjars\Pages;

use App\Filament\Resources\KategoriDanaBanjars\KategoriDanaBanjarResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateKategoriDanaBanjar extends CreateRecord
{
    protected static string $resource = KategoriDanaBanjarResource::class;

    public function getTitle(): string
    {
        return 'Tambah Kategori Dana';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->hidden();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}