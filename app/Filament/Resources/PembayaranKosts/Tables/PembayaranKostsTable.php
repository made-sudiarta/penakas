<?php

namespace App\Filament\Resources\PembayaranKosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PembayaranKostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tagihanKost.penghuni.nama')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('tagihanKost.kamarKost.nama_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('periode')
                    ->label('Periode')
                    ->state(function ($record): string {
                        $tagihan = $record->tagihanKost;

                        if (! $tagihan) {
                            return '-';
                        }

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

                        return ($bulan[$tagihan->bulan] ?? $tagihan->bulan) . ' ' . $tagihan->tahun;
                    }),

                TextColumn::make('tanggal_bayar')
                    ->label('Tanggal Bayar')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('jumlah_bayar')
                    ->label('Jumlah Bayar')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'qris' => 'QRIS',
                        'lainnya' => 'Lainnya',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'success',
                        'transfer' => 'primary',
                        'qris' => 'warning',
                        'lainnya' => 'gray',
                        default => 'gray',
                    }),

                ImageColumn::make('bukti_pembayaran')
                    ->label('Bukti')
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'qris' => 'QRIS',
                        'lainnya' => 'Lainnya',
                    ]),
            ])
            ->defaultSort('tanggal_bayar', 'desc')
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