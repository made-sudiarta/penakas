<?php

namespace App\Filament\Resources\PembayaranKosts\Pages;

use App\Filament\Resources\PembayaranKosts\PembayaranKostResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreatePembayaranKost extends CreateRecord
{
    protected static string $resource = PembayaranKostResource::class;

    public function getTitle(): string
    {
        return 'Tambah Pembayaran Kost';
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

    protected function afterCreate(): void
    {
        $this->record->tagihanKost?->updateStatusPembayaran();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}