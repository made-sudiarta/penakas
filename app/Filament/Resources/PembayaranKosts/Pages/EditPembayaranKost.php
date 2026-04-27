<?php

namespace App\Filament\Resources\PembayaranKosts\Pages;

use App\Filament\Resources\PembayaranKosts\PembayaranKostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditPembayaranKost extends EditRecord
{
    protected static string $resource = PembayaranKostResource::class;

    public function getTitle(): string
    {
        return 'Edit Pembayaran Kost';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->after(function () {
                    $this->record->tagihanKost?->updateStatusPembayaran();
                }),
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

    protected function afterSave(): void
    {
        $this->record->tagihanKost?->updateStatusPembayaran();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}