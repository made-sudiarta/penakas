<?php

namespace App\Filament\Resources\KamarKosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KamarKostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kamar')
                    ->label('Nama Kamar')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nomor_kamar')
                    ->label('Nomor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('harga_default')
                    ->label('Harga Bulanan')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'kosong' => 'Kosong',
                        'terisi' => 'Terisi',
                        'maintenance' => 'Maintenance',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'kosong' => 'success',
                        'terisi' => 'primary',
                        'maintenance' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'kosong' => 'Kosong',
                        'terisi' => 'Terisi',
                        'maintenance' => 'Maintenance',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}