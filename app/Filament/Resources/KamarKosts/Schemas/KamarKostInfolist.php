<?php

namespace App\Filament\Resources\KamarKosts\Schemas;

use App\Models\KamarKost;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class KamarKostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_kamar'),
                TextEntry::make('nomor_kamar')
                    ->placeholder('-'),
                TextEntry::make('harga_default')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('keterangan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (KamarKost $record): bool => $record->trashed()),
            ]);
    }
}
