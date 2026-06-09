<?php

namespace App\Filament\Resources\PeriodeBanjars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\PeriodeBanjar;
use Filament\Notifications\Notification;
use App\Models\TransaksiBanjar;

class PeriodeBanjarsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('nama')

                    ->searchable(),

                TextColumn::make('tanggal_mulai')

                    ->date('d M Y'),

                TextColumn::make('tanggal_selesai')

                    ->date('d M Y'),

                TextColumn::make('status')
                    ->state(fn ($record) => $record->is_active ? 'Aktif' : 'Nonaktif')
                    ->badge()
                    ->color(fn ($record) => $record->is_active ? 'success' : 'gray'),

                TextColumn::make('is_closed')
                    ->label('Status')
                    ->formatStateUsing(
                        fn ($state) => $state ? 'Closed' : 'Open'
                    )
                    ->badge()
                    ->color(
                        fn ($state) => $state ? 'danger' : 'success'
                    ),

                TextColumn::make('created_at')

                    ->since(),

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('aktifkan')
                    ->label('Aktifkan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => ! $record->is_active)
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        PeriodeBanjar::query()
                            ->update([
                                'is_active' => false,
                            ]);

                        $record->update([
                            'is_active' => true,
                        ]);
                    }),
                Action::make('tutupBuku')
                    ->label('Tutup Buku')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->visible(fn ($record) => ! $record->is_closed)
                    ->requiresConfirmation()
                    ->modalHeading('Tutup Periode')
                    ->modalDescription('Setelah ditutup, transaksi pada periode ini tidak dapat diubah.')
                    ->action(function ($record) {

                        $record->update([
                            'is_closed' => true,
                            'is_active' => false,
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Periode berhasil ditutup')
                            ->send();
                    }),
                Action::make('generateSaldoAwal')
                    ->label('Generate Saldo Awal')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        // Cek apakah sudah pernah dibuat
                        if (
                            TransaksiBanjar::where('periode_banjar_id', $record->id)
                                ->where('tipe', 'kas-awal')
                                ->exists()
                        ) {
                            Notification::make()
                                ->danger()
                                ->title('Saldo awal sudah pernah dibuat')
                                ->send();

                            return;
                        }

                        $periodeSebelumnya = \App\Models\PeriodeBanjar::query()
                            ->where('id', '<', $record->id)
                            ->latest('id')
                            ->first();

                        if (! $periodeSebelumnya) {

                            Notification::make()
                                ->danger()
                                ->title('Periode sebelumnya tidak ditemukan')
                                ->send();

                            return;
                        }
                        $akunMap = [
                                1 => \App\Models\AkunKeuanganBanjar::where('kode', '1103')->value('id'), // Deposito LPD
                                2 => \App\Models\AkunKeuanganBanjar::where('kode', '1102')->value('id'), // Tabungan LPD
                                7 => \App\Models\AkunKeuanganBanjar::where('kode', '1101')->value('id'), // Dana Cash
                                8 => \App\Models\AkunKeuanganBanjar::where('kode', '1104')->value('id'), // Kas Prajuru
                            ];
                        foreach ([1, 2, 7, 8] as $kategoriId) {

                            $saldo =
                                TransaksiBanjar::query()
                                    ->where('periode_banjar_id', $periodeSebelumnya->id)
                                    ->where('kategori_dana_banjar_id', $kategoriId)
                                    ->whereIn('tipe', ['kas-awal', 'pemasukan'])
                                    ->sum('nominal')

                                -

                                TransaksiBanjar::query()
                                    ->where('periode_banjar_id', $periodeSebelumnya->id)
                                    ->where('kategori_dana_banjar_id', $kategoriId)
                                    ->where('tipe', 'pengeluaran')
                                    ->sum('nominal');

                            if ($saldo <= 0) {
                                continue;
                            }
                            // dd($kategoriId, $akunMap, $akunMap[$kategoriId] ?? null);
                            TransaksiBanjar::create([

                                'periode_banjar_id' => $record->id,

                                'kategori_dana_banjar_id' => $kategoriId,

                                'akun_keuangan_banjar_id' => $akunMap[$kategoriId],

                                'tanggal' => $record->tanggal_mulai,

                                'tipe' => 'kas-awal',

                                'judul' => 'Kas Awal Periode ' . $record->nama,

                                'nominal' => $saldo,

                                'created_by' => auth()->id(),

                                'keterangan' => 'Dibuat otomatis dari saldo akhir periode sebelumnya',

                            ]);
                        }

                        Notification::make()
                            ->success()
                            ->title('Saldo awal berhasil dibuat')
                            ->send();
                    }),
                    
                ViewAction::make(),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
