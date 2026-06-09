<?php

namespace App\Filament\Resources\TransaksiBanjars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\PeriodeBanjar;

class TransaksiBanjarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('periode.nama')
                    ->label('Periode')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('akun.kode')
                    ->label('Kode')
                    ->sortable(),

                TextColumn::make('akun.nama')
                    ->label('Akun')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategoriDanaBanjar.nama')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tipe')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pemasukan' => 'success',
                        'pengeluaran' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                ImageColumn::make('foto_nota')
                    ->label('Nota')
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                TextColumn::make('pembuat.name')
                    ->label('Dibuat Oleh')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori_dana_banjar_id')
                    ->label('Kategori Dana')
                    ->relationship('kategoriDanaBanjar', 'nama')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('tipe')
                    ->label('Tipe Transaksi')
                    ->options([
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                    ]),
                SelectFilter::make('periode_banjar_id')
                    ->relationship('periode', 'nama')
                    ->label('Periode')
                    ->default(
                        fn () => PeriodeBanjar::query()
                            ->where('is_active', true)
                            ->value('id')
                    )
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('tanggal', 'desc')
            ->recordActions([
                EditAction::make()
                    ->visible(
                        fn ($record) =>
                            ! $record->periode?->is_closed
                    ),
                DeleteAction::make()
                    ->visible(
                        fn ($record) =>
                            ! $record->periode?->is_closed
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}