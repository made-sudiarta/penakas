<?php

namespace App\Filament\Resources\TransaksiBanjars\Pages;

use App\Filament\Resources\TransaksiBanjars\TransaksiBanjarResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use App\Models\PeriodeBanjar;
use Filament\Notifications\Notification;

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
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $periode = \App\Models\PeriodeBanjar::query()
            ->where('is_active', true)
            ->first();

        if (! $periode) {
            throw new \Exception('Tidak ada periode aktif.');
        }

        if ($periode->is_closed) {
            throw new \Exception('Periode sudah ditutup.');
        }

        $data['periode_banjar_id'] = $periode->id;

        return $data;
    }
}