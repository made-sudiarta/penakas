<?php

namespace App\Filament\Resources\JenisTagihanKosts\Pages;

use App\Filament\Resources\JenisTagihanKosts\JenisTagihanKostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditJenisTagihanKost extends EditRecord
{
    protected static string $resource = JenisTagihanKostResource::class;

    public function getTitle(): string
    {
        return 'Edit Jenis Tagihan';
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