<?php

namespace App\Filament\Resources\TagihanKosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TagihanKostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('penghuni.nama')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kamarKost.nama_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('periode')
                    ->label('Periode')
                    ->state(function ($record): string {
                        $bulan = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];

                        return ($bulan[$record->bulan] ?? $record->bulan) . ' ' . $record->tahun;
                    })
                    ->sortable(query: function ($query, string $direction) {
                        return $query
                            ->orderBy('tahun', $direction)
                            ->orderBy('bulan', $direction);
                    }),

                TextColumn::make('tanggal_jatuh_tempo')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('total_tagihan')
                    ->label('Tagihan')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('total_dibayar')
                    ->label('Dibayar')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('sisa')
                    ->label('Sisa')
                    ->state(fn ($record) => max(0, $record->total_tagihan - $record->total_dibayar))
                    ->money('IDR'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'belum_lunas' => 'Belum Lunas',
                        'sebagian' => 'Sebagian',
                        'lunas' => 'Lunas',
                        'dibatalkan' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'belum_lunas' => 'danger',
                        'sebagian' => 'warning',
                        'lunas' => 'success',
                        'dibatalkan' => 'gray',
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
                        'belum_lunas' => 'Belum Lunas',
                        'sebagian' => 'Sebagian',
                        'lunas' => 'Lunas',
                        'dibatalkan' => 'Dibatalkan',
                    ]),

                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ]),

                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(function (): array {
                        $tahunSekarang = (int) now()->format('Y');

                        return collect(range($tahunSekarang - 3, $tahunSekarang + 1))
                            ->mapWithKeys(fn ($tahun) => [$tahun => (string) $tahun])
                            ->toArray();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
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