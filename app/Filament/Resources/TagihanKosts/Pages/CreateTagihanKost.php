<?php

namespace App\Filament\Resources\TagihanKosts\Pages;

use App\Filament\Resources\TagihanKosts\TagihanKostResource;
use App\Models\TagihanKost;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Validation\ValidationException;

class CreateTagihanKost extends CreateRecord
{
    protected static string $resource = TagihanKostResource::class;

    public function getTitle(): string
    {
        return 'Tambah Tagihan Kost';
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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $sudahAda = TagihanKost::query()
            ->where('penghuni_id', $data['penghuni_id'])
            ->where('bulan', $data['bulan'])
            ->where('tahun', $data['tahun'])
            ->exists();

        if ($sudahAda) {
            Notification::make()
                ->title('Tagihan sudah ada')
                ->body('Tagihan untuk penghuni ini pada bulan dan tahun tersebut sudah pernah dibuat.')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'penghuni_id' => 'Tagihan untuk penghuni ini pada bulan dan tahun tersebut sudah ada.',
            ]);
        }

        $data['total_tagihan'] = 0;
        $data['total_dibayar'] = 0;
        $data['status'] = 'belum_lunas';

        return $data;
    }

    protected function afterCreate(): void
    {
        $totalTagihan = $this->record->details()
            ->sum('nominal');

        $this->record->update([
            'total_tagihan' => $totalTagihan,
            'total_dibayar' => 0,
            'status' => 'belum_lunas',
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}