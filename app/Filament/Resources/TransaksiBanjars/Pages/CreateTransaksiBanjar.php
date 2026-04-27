<?php

namespace App\Filament\Resources\TransaksiBanjars\Pages;

use App\Filament\Resources\TransaksiBanjars\TransaksiBanjarResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateTransaksiBanjar extends CreateRecord
{
    protected static string $resource = TransaksiBanjarResource::class;

    public function getTitle(): string
    {
        return 'Tambah Transaksi Banjar';
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