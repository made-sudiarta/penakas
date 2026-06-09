<?php

namespace App\Filament\Resources\AkunKeuanganBanjars\Pages;

use App\Filament\Resources\AkunKeuanganBanjars\AkunKeuanganBanjarResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAkunKeuanganBanjar extends EditRecord
{
    protected static string $resource = AkunKeuanganBanjarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
            ->visible(
                fn ($record) =>
                    $record->transaksiBanjars()->count() === 0
            ),
        ];
    }
}
