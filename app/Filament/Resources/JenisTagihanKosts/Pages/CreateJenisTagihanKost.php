<?php

namespace App\Filament\Resources\JenisTagihanKosts\Pages;

use App\Filament\Resources\JenisTagihanKosts\JenisTagihanKostResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateJenisTagihanKost extends CreateRecord
{
    protected static string $resource = JenisTagihanKostResource::class;

    public function getTitle(): string
    {
        return 'Tambah Jenis Tagihan';
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