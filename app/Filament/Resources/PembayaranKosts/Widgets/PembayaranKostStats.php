<?php

namespace App\Filament\Resources\PembayaranKosts\Widgets;

use App\Models\PembayaranKost;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PembayaranKostStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Pembayaran Kost';

    protected ?string $description = 'Statistik pembayaran kost yang sudah masuk.';

    protected function getColumns(): int|array
    {
        return [
            'default' => 3,
            'md' => 3,
        ];
    }

    protected function getStats(): array
    {
        $totalPembayaran = PembayaranKost::query()
            ->sum('jumlah_bayar');

        $bulanIni = PembayaranKost::query()
            ->whereYear('tanggal_bayar', now()->year)
            ->whereMonth('tanggal_bayar', now()->month)
            ->sum('jumlah_bayar');

        $jumlahTransaksi = PembayaranKost::query()
            ->count();

        return [
            Stat::make('Total', 'Rp ' . number_format($totalPembayaran, 0, ',', '.'))
                ->description('Semua')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->icon(Heroicon::OutlinedCreditCard)
                ->color('primary')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),

            Stat::make('Bulan Ini', 'Rp ' . number_format($bulanIni, 0, ',', '.'))
                ->description('Masuk')
                ->descriptionIcon(Heroicon::OutlinedCalendarDays)
                ->icon(Heroicon::OutlinedWallet)
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
                ]),

            Stat::make('Transaksi', number_format($jumlahTransaksi, 0, ',', '.'))
                ->description('Jumlah')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedReceiptPercent)
                ->color('warning')
                ->extraAttributes([
                    'class' => 'bg-warning-50 dark:bg-warning-950/30 border border-warning-100 dark:border-warning-900 p-2 sm:p-4',
                ]),
        ];
    }
}