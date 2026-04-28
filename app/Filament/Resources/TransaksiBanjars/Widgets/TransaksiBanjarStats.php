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
            'md' => 3,
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

        $saldo = $pemasukan - $pengeluaran;

        return [
            Stat::make('Masuk', 'Rp ' . number_format($pemasukan, 0, ',', '.'))
                ->description('Pemasukan')
                ->descriptionIcon(Heroicon::OutlinedArrowDownCircle)
                ->icon(Heroicon::OutlinedBanknotes)
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
                ]),

            Stat::make('Keluar', 'Rp ' . number_format($pengeluaran, 0, ',', '.'))
                ->description('Pengeluaran')
                ->descriptionIcon(Heroicon::OutlinedArrowUpCircle)
                ->icon(Heroicon::OutlinedShoppingBag)
                ->color('danger')
                ->extraAttributes([
                    'class' => 'bg-danger-50 dark:bg-danger-950/30 border border-danger-100 dark:border-danger-900 p-2 sm:p-4',
                ]),

            Stat::make('Saldo', 'Rp ' . number_format($saldo, 0, ',', '.'))
                ->description('Sisa dana')
                ->descriptionIcon(Heroicon::OutlinedScale)
                ->icon(Heroicon::OutlinedWallet)
                ->color($saldo >= 0 ? 'primary' : 'danger')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),
        ];
    }
}