<?php

namespace App\Filament\Resources\TagihanKosts\Pages;

use App\Filament\Resources\TagihanKosts\TagihanKostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditTagihanKost extends EditRecord
{
    protected static string $resource = TagihanKostResource::class;

    public function getTitle(): string
    {
        return 'Edit Tagihan Kost';
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

    protected function afterSave(): void
    {
        $totalTagihan = $this->record->details()
            ->sum('nominal');

        $this->record->update([
            'total_tagihan' => $totalTagihan,
        ]);

        $this->record->updateStatusPembayaran();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}