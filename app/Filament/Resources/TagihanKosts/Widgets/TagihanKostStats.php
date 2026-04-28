<?php

namespace App\Filament\Resources\TagihanKosts\Widgets;

use App\Models\TagihanKost;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TagihanKostStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Tagihan Kost';

    protected ?string $description = 'Statistik tagihan kost berdasarkan status pembayaran.';

    protected function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 3,
        ];
    }

    protected function getStats(): array
    {
        $totalTagihan = TagihanKost::query()->sum('total_tagihan');

        $totalDibayar = TagihanKost::query()->sum('total_dibayar');

        $belumLunas = TagihanKost::query()
            ->whereIn('status', ['belum_lunas', 'sebagian'])
            ->sum(\DB::raw('GREATEST(total_tagihan - total_dibayar, 0)'));

        return [
            Stat::make('Tagihan', 'Rp ' . number_format($totalTagihan, 0, ',', '.'))
                ->description('Total')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->icon(Heroicon::OutlinedDocumentCurrencyDollar)
                ->color('primary')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),

            Stat::make('Dibayar', 'Rp ' . number_format($totalDibayar, 0, ',', '.'))
                ->description('Masuk')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedWallet)
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
                ]),

            Stat::make('Sisa', 'Rp ' . number_format($belumLunas, 0, ',', '.'))
                ->description('Belum lunas')
                ->descriptionIcon(Heroicon::OutlinedExclamationCircle)
                ->icon(Heroicon::OutlinedClock)
                ->color('danger')
                ->extraAttributes([
                    'class' => 'bg-danger-50 dark:bg-danger-950/30 border border-danger-100 dark:border-danger-900 p-2 sm:p-4',
                ]),
        ];
    }
}