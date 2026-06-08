<?php

namespace App\Filament\Resources\TransaksiBanjars\Widgets;

use App\Models\TransaksiBanjar;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransaksiBanjarStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Transaksi Banjar';

    protected ?string $description = 'Statistik pemasukan, pengeluaran, dan saldo dana banjar.';

    protected function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 4,
        ];
    }

    protected function getStats(): array
    {
        $pemasukan = TransaksiBanjar::query()
            ->where('tipe', 'pemasukan')
            ->sum('nominal');

        $pengeluaran = TransaksiBanjar::query()
            ->where('tipe', 'pengeluaran')
            ->sum('nominal');

        $depositoLPD =
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 1)
                ->where('tipe', 'kas-awal')
                ->sum('nominal')
            +
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 1)
                ->where('tipe', 'pemasukan')
                ->sum('nominal')
            -
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 1)
                ->where('tipe', 'pengeluaran')
                ->sum('nominal');

        $tabunganLPD = 
        TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 2)
                ->where('tipe', 'kas-awal')
                ->sum('nominal')
            +
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 2)
                ->where('tipe', 'pemasukan')
                ->sum('nominal')
            -
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 2)
                ->where('tipe', 'pengeluaran')
                ->sum('nominal');
        $danaCash = 
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 7)
                ->where('tipe', 'kas-awal')
                ->sum('nominal')
            +
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 7)
                ->where('tipe', 'pemasukan')
                ->sum('nominal')
            -
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 7)
                ->where('tipe', 'pengeluaran')
                ->sum('nominal');
        $kasPrajuru = 
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 8)
                ->where('tipe', 'kas-awal')
                ->sum('nominal')
            +
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 8)
                ->where('tipe', 'pemasukan')
                ->sum('nominal')
            -
            TransaksiBanjar::query()
                ->where('kategori_dana_banjar_id', 8)
                ->where('tipe', 'pengeluaran')
                ->sum('nominal');

        $saldoBanjar = $depositoLPD + $tabunganLPD + $danaCash + $kasPrajuru;

        return [
            Stat::make('Deposito LPD', 'Rp ' . number_format($depositoLPD, 0, ',', '.'))
                ->description('Pemasukan')
                ->descriptionIcon(Heroicon::OutlinedArrowDownCircle)
                ->icon(Heroicon::OutlinedBanknotes)
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
                ]),

            Stat::make('Tabungan LPD', 'Rp ' . number_format($tabunganLPD, 0, ',', '.'))
                ->description('Pengeluaran')
                ->descriptionIcon(Heroicon::OutlinedArrowUpCircle)
                ->icon(Heroicon::OutlinedShoppingBag)
                ->color('danger')
                ->extraAttributes([
                    'class' => 'bg-danger-50 dark:bg-danger-950/30 border border-danger-100 dark:border-danger-900 p-2 sm:p-4',
                ]),

            Stat::make('Dana Cash', 'Rp ' . number_format($danaCash, 0, ',', '.'))
                ->description('Sisa dana')
                ->descriptionIcon(Heroicon::OutlinedScale)
                ->icon(Heroicon::OutlinedWallet)
                ->color($danaCash >= 0 ? 'primary' : 'danger')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),
            Stat::make('Kas Prajuru', 'Rp ' . number_format($kasPrajuru, 0, ',', '.'))
                ->description('Sisa dana')
                ->descriptionIcon(Heroicon::OutlinedScale)
                ->icon(Heroicon::OutlinedWallet)
                ->color($kasPrajuru >= 0 ? 'primary' : 'danger')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),
        ];
    }
}