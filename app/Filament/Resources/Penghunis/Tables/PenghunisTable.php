<?php

namespace App\Filament\Resources\Penghunis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PenghunisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Penghuni')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kamarKost.nama_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('tanggal_masuk')
                    ->label('Masuk')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'aktif' => 'Aktif',
                        'keluar' => 'Keluar',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'keluar' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('tanggal_keluar')
                    ->label('Keluar')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

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
                        'aktif' => 'Aktif',
                        'keluar' => 'Keluar',
                    ]),

                SelectFilter::make('kamar_kost_id')
                    ->label('Kamar')
                    ->relationship('kamarKost', 'nama_kamar')
                    ->searchable()
                    ->preload(),
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